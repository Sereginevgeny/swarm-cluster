<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('/polls', 'PollResourceController');
Route::get('/summary', 'PollSummaryController@summary');
Route::get('/polls/{id}/results', 'PollSummaryController@results');
Route::post('/polls/{id}/vote', 'VoteController@vote');
