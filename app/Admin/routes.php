<?php

Route::get('', ['as' => 'admin.dashboard', 'uses' => '\App\Http\Controllers\HomeController@dashboard']);

Route::get('add_user_stock/{stock_id}', ['as' => 'admin.add_user_stock', function($stock_id){
    Auth::user()->stocks()->attach($stock_id);
    return 1;
}]);

Route::get('remove_user_stock/{stock_id}', ['as' => 'admin.add_remove_stock', function($stock_id){
    Auth::user()->stocks()->detach($stock_id);
    return redirect('admin/');
}]);

Route::get('/tree', ['as' => 'admin.tree', 'uses' => '\App\Http\Controllers\HomeController@tree']);

Route::get('/chart', ['as' => 'admin.chart', 'uses' => '\App\Http\Controllers\HomeController@charts']);

Route::get('/information', ['as' => 'admin.information', function () {
	$content = 'You could paste your information here.';
	return AdminSection::view($content, 'Information');
}]);

Route::post('/news/export.json', ['as' => 'admin.news.export', function () {
	$response = new \Illuminate\Http\JsonResponse([
		'title' => 'Congratulation! You exported news.',
		'news' => App\Model\News::whereIn('id', Request::get('id', []))->get()
	]);

	$response->setJsonOptions(JSON_PRETTY_PRINT);

	return $response;
}]);