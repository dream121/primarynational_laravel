<?php

class DashboardController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$count_users=User::where('recent_status','=',1)->count();
		$count_comments=Comment::where('recent_status','=',1)->count();
		$requests=Feedback::select(DB::raw('count(*) as request_count, type'))->where('recent_status','=',1)->groupBy('type')->get()->toArray();
		$count=null;
		foreach($requests as $request){
			switch($request['type']){
				case 'buy':
					$count['buy']=$request['request_count'];
					break;
				case 'sell':
					$count['sell']=$request['request_count'];
					break;
				case 'request showing':
					$count['showing']=$request['request_count'];
					break;
				case 'finance':
					$count['finance']=$request['request_count'];
					break;
			}
		}
		return View::make('admin.dashboard.index')->with(compact('count','count_comments','count_users'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
