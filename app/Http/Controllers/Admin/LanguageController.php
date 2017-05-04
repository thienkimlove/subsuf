<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private $request;
    private $languageRepository;

    public function __construct(Request $request, LanguageRepository $languageRepository)
    {
        $this->request = $request;
        $this->title = 'Danh mục Ngôn ngữ';
        $this->languageRepository = $languageRepository;
    }

    public function index()
    {
        $languages = $this->languageRepository->getAll();

        $response = [
            'title' => $this->title,
            'languages' => $languages
        ];

        return view('admin.system_category.language.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
        ];

        if ($this->request->isMethod('post')) {
            $validator = language_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_language_form($this->request);
                    $this->languageRepository->insert($data);

                    return \Redirect::action('Admin\LanguageController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.language.insert', $response);
    }

    public function info($id)
    {
        $language = $this->languageRepository->find($id);
        if ($language != null) {
            $response = [
                'title' => $this->title,
                'language' => $language
            ];

            return view('admin.system_category.language.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $language = $this->languageRepository->find($id);
        if ($language != null) {
            $response = [
                'title' => $this->title,
                'language' => $language
            ];

            if ($this->request->isMethod('post')) {
                $validator = language_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_language_form($this->request);
                        $this->languageRepository->update($id, $data);

                        return \Redirect::action('Admin\LanguageController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.language.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->languageRepository->delete($id)) {
                return \Redirect::action('Admin\LanguageController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
