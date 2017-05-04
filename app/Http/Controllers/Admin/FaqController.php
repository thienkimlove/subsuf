<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\FaqRepository;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private $request;
    private $faqRepository;
    private $languageRepository;

    public function __construct(Request $request, FaqRepository $faqRepository, LanguageRepository $languageRepository)
    {
        $this->request = $request;
        $this->title = 'Quản lý FAQ';
        $this->faqRepository = $faqRepository;
        $this->languageRepository = $languageRepository;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('faq_type')) {
            $faq_type = trim($this->request->input('faq_type'));
            if ($faq_type != "") {
                $query['faq_type'] = "faq_type = $faq_type";
            }
        }

        if ($this->request->has('language')) {
            $language = trim($this->request->input('language'));
            if ($language != "") {
                $query['language'] = "language = '$language'";
            }
        }

        if ($this->request->has('ask')) {
            $ask = trim($this->request->input('ask'));
            $query['ask'] = "ask LIKE '%$ask%'";
        }

        $faqs = $this->faqRepository->getLimit(30, $query);
        $faq_types = StatusHelper::faq();
        $languages = $this->languageRepository->getAll();

        $response = [
            'title' => $this->title,
            'faqs' => $faqs,
            'languages' => $languages,
            'faq_types' => $faq_types
        ];

        $this->request->flash();

        return view('admin.config-manage.faq.index', $response);
    }

    public function insert()
    {
        $languages = $this->languageRepository->getAll();
        $faq_types = StatusHelper::faq();

        $response = [
            'title' => $this->title,
            'languages' => $languages,
            'faq_types' => $faq_types
        ];

        if ($this->request->isMethod('post')) {
            $validator = faq_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_faq_form($this->request);
                    $this->faqRepository->insert($data);

                    return \Redirect::action('Admin\FaqController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.faq.insert', $response);
    }

    public function update($faq_id)
    {
        $faq = $this->faqRepository->find($faq_id);

        if ($faq != null) {
            $languages = $this->languageRepository->getAll();
            $faq_types = StatusHelper::faq();
            $response = [
                'title' => $this->title,
                'faq' => $faq,
                'languages' => $languages,
                'faq_types' => $faq_types
            ];

            if ($this->request->isMethod('post')) {
                $validator = faq_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_faq_form($this->request);
                        $this->faqRepository->update($faq_id, $data);

                        return \Redirect::action('Admin\FaqController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.faq.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($faq_id)
    {
        try {
            if ($this->faqRepository->delete($faq_id)) {
                return \Redirect::action('Admin\FaqController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function get_faq()
    {
        $locale = \App::getLocale();
        if ($locale == '') {
            $locale = 'vi';
        }

        $shopper_faqs = $this->faqRepository->getAll(["language = '$locale'", "faq_type = " . faq_shopper()]);
        $traveler_faqs = $this->faqRepository->getAll(["language = '$locale'", "faq_type = " . faq_traveler()]);
        $other_faqs = $this->faqRepository->getAll(["language = '$locale'", "faq_type = " . faq_others()]);

        $response = [
            'title' => 'FAQ',
            'shopper_faqs' => $shopper_faqs,
            'traveler_faqs' => $traveler_faqs,
            'other_faqs' => $other_faqs
        ];

        return view('frontend.faq', $response);
    }
}