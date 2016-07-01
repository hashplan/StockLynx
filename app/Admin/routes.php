<?php

Route::get('', ['as' => 'admin.dashboard', 'uses' => '\App\Http\Controllers\HomeController@dashboard']);

Route::get('/information', ['as' => 'admin.information', function () {
	$content = 'You could paste your information here.';
	return AdminSection::view($content, 'Information');
}]);

Route::get('/tree', ['as' => 'admin.tree', 'uses' => '\App\Http\Controllers\HomeController@tree']);
Route::get('/branch', ['as' => 'admin.brunch', 'uses' => '\App\Http\Controllers\HomeController@branch']);
Route::get('/scenario', ['as' => 'admin.scenario', 'uses' => '\App\Http\Controllers\HomeController@scenario']);

Route::post('/news/export.json', ['as' => 'admin.news.export', function () {
	$response = new \Illuminate\Http\JsonResponse([
		'title' => 'Congratulation! You exported news.',
		'news' => App\Model\News::whereIn('id', Request::get('id', []))->get()
	]);

	$response->setJsonOptions(JSON_PRETTY_PRINT);

	return $response;
}]);