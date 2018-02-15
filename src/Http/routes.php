<?php

Route::get('/lang/{lang?}', 'LocaleController@changeLanguage')->name('locale');
