<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Str;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::all();

        return view('adminpages.teamcrud.index', ["title" => "Index Team", 'teams' => $team]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminpages.teamcrud.create', ["title" => "Create Team"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Team();
        $data->Name_Team  = $request->Name_Team;
        
        $data->save();

        return redirect()->back()->with('success', 'Team is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Team $member)

    {
        $team_member = DB::table('team_members')
            ->leftJoin('users', 'users.id', '=', 'team_members.id')
            ->rightJoin('teams', 'teams.id', '=', 'team_members.id')
            ->get();
        
        return view('adminpages.teamcrud.show', ["title" => 'Details'], compact('member'))->with('members', $team_member);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);

        return view('adminpages.teamcrud.edit', ["title" => "Edit Team"], compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Team::findOrFail($id);
        $data->Name_Team  = $request->Name_Team;
        $data->save();

        return redirect('/lineup')->with('success', 'Team Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Team::findOrFail($id);
        $user->delete();

        return redirect('/lineup')->with('success', 'Team Data is successfully deleted');
    }
    
    public function add_team_member(Request $request)
    {
        $team_member = DB::table('team_members')
        ->leftJoin('users', 'users.id', '=', 'team_members.id')
        ->rightJoin('teams', 'teams.id', '=', 'team_members.id')
        ->get();

        $data = new TeamMember();
        $data->name = $request->name;
        $data->name_team = $request->name_team;
        
        $data->save();

        return view('adminpages.lineup', ["title" => "Edit Team"], compact('team'))->with('team_members', $team_member);
    }
}