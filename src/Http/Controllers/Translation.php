<?php

namespace Rzakhanov\Translation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Rzakhanov\Translation\Services\Data;

class Translation extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function all(Request $request): JsonResponse
    {
        $data = Data::all($request->input('search_key'));

        return response()->json([
            'indexes' => $data['lang_indexes'],
            'all_indexes' => $data['all_indexes'],
            'groups' => $data['groups'],
            'languages' => collect($data['lang_paths'])->mapWithKeys(function ($lang) use ($data) {
                return [$lang => $data['all_languages'][$lang]];
            }),
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'group' => 'required|string|max:500',
            'index' => 'required|string|max:500',
            'translation' => 'array|required',
            'translation.*' => 'string|max:65535',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'response' => false,
                'message' => "Inputs cannot be empty",
            ], 422);
        }


        $data = Data::all();
        $group = $request->input('group');
        $index = $request->input('index');
        $translation = $request->input('translation');


        if (!isset($data['all_indexes'][$group][$request->input('index')])) {

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($data, $group, $index, $translation) {
                $newCollect = array_reverse($data['lang_indexes'][$group][$lang] ?? []);
                $newCollect[$index] = isset($translation[$lang]) ? (string)$translation[$lang] : null;

                $fopen = fopen(config('rzakhanov-translation.lang_path') . '/' . $lang . '/' . $group . '.php', 'w+');
                fputs($fopen, Data::replaceToContent($newCollect));
                fclose($fopen);
            });

        } else {
            return response()->json([
                'response' => false,
                'message' => 'Group or index already exists',
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
            'group' => 'required|string|max:500',
            'index' => 'required|string|max:500',
            'old_index' => 'required|string|max:500',
            'translation' => 'array|required',
            'translation.*' => 'string|max:65535',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'response' => false,
                'message' => "Inputs cannot be empty",
            ], 422);
        }

        $data = Data::all();
        $group = $request->input('group');
        $index = $request->input('index');
        $old_index = $request->input('old_index');
        $translation = $request->input('translation');


        if (isset($data['all_indexes'][$group][$old_index])) {

            if ($index !== $old_index && isset($data['all_indexes'][$group][$index])) {

                return response()->json([
                    'response' => false,
                    'message' => 'New index name already exits',
                ], 422);
            }

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($data, $group, $index, $translation, $old_index) {
                $newCollect = array_reverse($data['lang_indexes'][$group][$lang] ?? []);
                unset($newCollect[$old_index]);
                $newCollect[$index] = isset($translation[$lang]) ? (string)$translation[$lang] : null;

                $fopen = fopen(config('rzakhanov-translation.lang_path') . '/' . $lang . '/' . $group . '.php', 'w+');
                fputs($fopen, Data::replaceToContent($newCollect));
                fclose($fopen);
            });

        } else {
            return response()->json([
                'response' => false,
                'message' => 'Group or index doesn\'t exist',
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
            'group' => 'required|string|max:500',
            'index' => 'required|string|max:500',
        ]);


        if ($validation->fails()) {

            return response()->json([
                'response' => false,
                'message' => 'Group, index or translated languages don\'t exit',
            ], 422);
        }

        $data = Data::all();
        $group = $request->input('group');
        $index = $request->input('index');

        if (isset($data['all_indexes'][$group][$index])) {

            collect(array_keys($data['all_languages']))->map(function ($lang) use ($data, $group, $index) {
                $newCollect = array_reverse($data['lang_indexes'][$group][$lang]??[]);
                unset($newCollect[$index]);

                $fopen = fopen(config('rzakhanov-translation.lang_path') . '/' . $lang . '/' . $group . '.php', 'w+');
                fputs($fopen, Data::replaceToContent($newCollect));
                fclose($fopen);
            });

        } else {
            return response()->json([
                'response' => false,
                'message' => 'Group or index doesn\'t exit. Maybe it was deleted',
            ], 422);
        }

        return response()->json([
            'response' => true,
            'message' => 'Successfully deleted',
        ]);
    }
}
