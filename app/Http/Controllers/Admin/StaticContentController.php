<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Banner;
use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepository;
use App\Repositories\StaticContentRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    private $request;
    private $contentRepository;
    private $languageRepository;

    public function __construct(Request $request, StaticContentRepository $contentRepository,
                                LanguageRepository $languageRepository)
    {
        $this->request = $request;
        $this->contentRepository = $contentRepository;
        $this->languageRepository = $languageRepository;
    }

    public function policy()
    {
        $policies = $this->contentRepository->findPolicies();

        $response = [
            'title' => 'Quản lý Chính sách',
            'policies' => $policies
        ];

        return view('admin.config-manage.policy.index', $response);
    }

    public function policy_insert()
    {
        $languages = $this->languageRepository->getAll();

        $response = [
            'title' => 'Quản lý Chính sách',
            'languages' => $languages
        ];

        if ($this->request->isMethod('post')) {
            $validator = static_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_static_form($this->request);
                    $data['id'] = get_policy();
                    $data['language'] = trim($this->request->input('language', 'en'));

                    $this->contentRepository->insert($data);

                    return \Redirect::action('Admin\StaticContentController@policy')->withSuccess(message_insert());
                } catch (QueryException $queryException) {
                    return \Redirect::back()->withError("Đã có ngôn ngữ");
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.policy.insert', $response);
    }

    public function policy_update($language_code)
    {
        $policy = $this->contentRepository->find(get_policy(), $language_code);
        if ($policy != null) {
            $response = [
                'title' => 'Quản lý Chính sách',
                'policy' => $policy
            ];

            if ($this->request->isMethod('post')) {
                $validator = static_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_static_form($this->request);
                        $this->contentRepository->update(get_policy(), $language_code, $data);

                        return \Redirect::action('Admin\StaticContentController@policy')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.policy.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function check_policy()
    {
        $language = trim($this->request->input('language', 'en'));
        if ($this->contentRepository->find(get_policy(), $language) != null) {
            return 1;
        } else {
            return 0;
        }
    }

    public function terms()
    {
        $terms = $this->contentRepository->findTerms();

        $response = [
            'title' => 'Quản lý Điều khoản',
            'terms' => $terms
        ];

        return view('admin.config-manage.terms.index', $response);
    }

    public function banners()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.config-manage.banners.index', [

            'title' => 'Quản lý banner',
            'banners' => $banners
        ]);
    }

    public function banner_insert()
    {
        return view('admin.config-manage.banners.insert');
    }

    public function banner_update($banner_id)
    {
        $banner = Banner::find($banner_id);
        if ($banner != null) {
            $response = [
                'title' => 'Quản lý banner',
                'banner' => $banner,
            ];

            if ($this->request->isMethod('post')) {
                $validator = banner_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_banner_form($this->request);

                        Banner::find($banner_id)->update($data);

                        return \Redirect::action('Admin\StaticContentController@banners')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.banners.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function terms_insert()
    {
        $languages = $this->languageRepository->getAll();

        $response = [
            'title' => 'Quản lý Chính sách',
            'languages' => $languages
        ];

        if ($this->request->isMethod('post')) {
            $validator = static_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_static_form($this->request);
                    $data['id'] = get_term();
                    $data['language'] = trim($this->request->input('language', 'en'));

                    $this->contentRepository->insert($data);

                    return \Redirect::action('Admin\StaticContentController@terms')->withSuccess(message_insert());
                } catch (QueryException $queryException) {
                    return \Redirect::back()->withError("Đã có ngôn ngữ");
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.terms.insert', $response);
    }

    public function terms_update($language_code)
    {
        $term = $this->contentRepository->find(get_term(), $language_code);
        if ($term != null) {
            $response = [
                'title' => 'Quản lý Chính sách',
                'term' => $term
            ];

            if ($this->request->isMethod('post')) {
                $validator = static_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_static_form($this->request);
                        $this->contentRepository->update(get_term(), $language_code, $data);

                        return \Redirect::action('Admin\StaticContentController@terms')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.terms.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function check_terms()
    {
        $language = trim($this->request->input('language', 'en'));
        if ($this->contentRepository->find(2, $language) != null) {
            return 1;
        } else {
            return 0;
        }
    }

    public function abouts()
    {
        $abouts = $this->contentRepository->findAbouts();

        $response = [
            'title' => 'Quản lý About Me',
            'abouts' => $abouts
        ];

        return view('admin.config-manage.about_me.index', $response);
    }

    public function about_insert()
    {
        $languages = $this->languageRepository->getAll();

        $response = [
            'title' => 'Quản lý About Me',
            'languages' => $languages
        ];

        if ($this->request->isMethod('post')) {
            $validator = static_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_static_form($this->request);
                    $data['id'] = get_about();
                    $data['language'] = trim($this->request->input('language', 'en'));

                    $this->contentRepository->insert($data);

                    return \Redirect::action('Admin\StaticContentController@abouts')->withSuccess(message_insert());
                } catch (QueryException $queryException) {
                    return \Redirect::back()->withError("Đã có ngôn ngữ");
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.about_me.insert', $response);
    }

    public function about_update($language_code)
    {
        $about = $this->contentRepository->find(get_about(), $language_code);
        if ($about != null) {
            $response = [
                'title' => 'Quản lý About Me',
                'about' => $about
            ];

            if ($this->request->isMethod('post')) {
                $validator = static_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_static_form($this->request);
                        $this->contentRepository->update(get_about(), $language_code, $data);

                        return \Redirect::action('Admin\StaticContentController@abouts')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.about_me.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function check_about()
    {
        $language = trim($this->request->input('language', 'en'));
        if ($this->contentRepository->find(get_about(), $language) != null) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_about()
    {
        $locale = \App::getLocale();
        if ($locale == '') {
            $locale = 'vi';
        }

        $about = $this->contentRepository->find(get_about(), $locale);
        $response = [
            'title' => $about->title,
            'about' => $about
        ];

        return view('frontend.about', $response);
    }

    public function get_policy()
    {
        $locale = \App::getLocale();
        if ($locale == '') {
            $locale = 'vi';
        }

        $policy = $this->contentRepository->find(get_policy(), $locale);
        $response = [
            'title' => $policy->title,
            'policy' => $policy
        ];

        return view('frontend.policy', $response);
    }

    public function get_term()
    {
        $locale = \App::getLocale();
        if ($locale == '') {
            $locale = 'vi';
        }

        $term = $this->contentRepository->find(get_term(), $locale);
        $response = [
            'title' => $term->title,
            'term' => $term
        ];

        return view('frontend.term', $response);
    }
}