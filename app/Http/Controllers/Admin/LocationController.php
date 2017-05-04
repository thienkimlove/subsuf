<?php

namespace App\Http\Controllers\Admin;

use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private $request;
    private $locationRepository;

    public function __construct(Request $request, LocationRepository $locationRepository)
    {
        $this->request = $request;
        $this->title = 'Danh mục Địa điểm';
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('location')) {
            $query['name'] = $this->request->input('location');
        }

        if ($this->request->has('type')) {
            if ($this->request->input('type') != -1) {
                $query['type'] = $this->request->input('type');
            }
        }

        $locations = $this->locationRepository->getLimit(30, $query);

        $response = [
            'title' => $this->title,
            'locations' => $locations,
            'type_location' => StatusHelper::type_location()
        ];

        $this->request->flashOnly(['location', 'type']);

        return view('admin.system_category.location.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
            'type_location' => StatusHelper::type_location()
        ];

        if ($this->request->isMethod('post')) {
            $validator = location_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_location_form($this->request);
                    $this->locationRepository->insert($data);

                    return \Redirect::action('Admin\LocationController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.location.insert', $response);
    }

    public function info($id)
    {
        $location = $this->locationRepository->find($id);
        if ($location != null) {
            $response = [
                'title' => $this->title,
                'location' => $location
            ];

            return view('admin.system_category.location.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $location = $this->locationRepository->find($id);
        if ($location != null) {
            $response = [
                'title' => $this->title,
                'location' => $location,
                'type_location' => StatusHelper::type_location()
            ];

            if ($this->request->isMethod('post')) {
                $validator = location_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_location_form($this->request);
                        $this->locationRepository->update($id, $data);

                        return \Redirect::action('Admin\LocationController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.location.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->locationRepository->delete($id)) {
                return \Redirect::action('Admin\LocationController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
