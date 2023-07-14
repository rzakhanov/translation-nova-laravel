<?php

namespace Rzakhanov\Translation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Rzakhanov\Translation\Services\Data;

class Groups extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function all(Request $request): JsonResponse
    {
        return response()->json(Data::groups());
    }


    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'index' => 'required|regex:/^[A-z0-9-]{1,250}$/i',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'response' => false,
                'message' => "Group name cannot be empty. Group name size must 250  and contained A-z 0-9 - _ symbols ",
            ], 422);
        }


        $data = Data::all();
        $groups = Data::groups();
        $index = $request->input('index');


        if (!isset($groups[$index])) {

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($data, $index) {
                $filepath = config('rzakhanov-translation.lang_path') . $lang . '/' . $index . '.php';

                if (!file_exists($filepath)) {
                    $configContent = "<?php\n\treturn [ ];\n?>";

                    $fopen = fopen($filepath, 'w+');
                    fputs($fopen, $configContent);
                    fclose($fopen);
                }
            });


        } else {
            return response()->json([
                'response' => false,
                'message' => 'Language index already exists',
            ], 422);
        }


        return response()->json([
            'response' => true,
            'message' => '',
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'index' => 'required|regex:/^[A-z0-9-]{1,250}$/i',
            'old_index' => 'required|regex:/^[A-z0-9-]{1,250}$/i',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'response' => false,
                'message' => "Inputs cannot be empty. Index must 2 symbols, description maximum 50",
            ], 422);
        }


        $data = Data::all();
        $index = $request->input('index');
        $old_index = $request->input('old_index');


        if ($old_index !== $index && !in_array($index, $data['groups'])) {

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($data, $index, $old_index) {
                $lang_path = config('rzakhanov-translation.lang_path');
                if (!file_exists($lang_path . $lang . '/' . $index . '.php')) {

                    /*if(!File::isDirectory($lang_path . 'trash/')) {
                        mkdir($lang_path . 'trash/',0777,true);
                    }

                    if(!File::isDirectory($lang_path . 'trash/'.$lang.'/')) {
                        mkdir($lang_path . 'trash/'.$lang,0777,true);
                    }

                    File::copy(
                        $lang_path . $lang . '/' . $old_index . '.php',
                        $lang_path . 'trash/'.$lang.'/'.$old_index . '.php');*/

                    File::move(
                        $lang_path . $lang . '/' . $old_index . '.php',
                        $lang_path . $lang . '/' . $index . '.php');
                }
            });

        } else {
            return response()->json([
                'response' => false,
                'message' => 'Group already exists',
            ], 422);
        }

        return response()->json([
            'response' => true,
            'message' => '',
        ]);
    }


    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'index' => 'required|regex:/^[A-z0-9-]{1,250}$/i',
        ]);

        $index = $request->input('index');

        if ($validation->fails()) {

            return response()->json([
                'response' => false,
                'message' => 'Error index name',
            ], 422);
        }

        $data = Data::all();
        $groups = $data['groups'];

        if (!in_array($index, $groups)) {
            return response()->json([
                'response' => false,
                'message' => 'Group not found',
            ], 422);
        }

        try {

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($index) {
                $lang_path = config('rzakhanov-translation.lang_path');
                if (file_exists($lang_path . $lang . '/' . $index . '.php')) {

                    File::delete($lang_path . $lang . '/' . $index . '.php');
                }
            });


            return response()->json([
                'response' => true,
                'message' => '',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'response' => true,
                'message' => 'Error !' . $exception,
            ], 422);
        }
    }
}
