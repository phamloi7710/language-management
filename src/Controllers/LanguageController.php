<?php

namespace LoiPham\Language\Controllers;

use Illuminate\Http\Request;
use Assets;
use LoiPham\Language\Supports\Language;
use LoiPham\Language\Models\Language as LangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class LanguageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        page_title()->setTitle(__('language::language.language_management'));
        Assets::addScripts(['select2', 'language', 'sweet-alert2'])->addStyles(['select2', 'select2bs4', 'icheck-bootstrap', 'animate', 'sweet-alert2']);
        $languages = Language::getListLanguages();
        $languageData = LangModel::where(['deleted_at' => null, 'deleted_by' => null])->get();
        if(request()->has('locale')){
            $locale = LangModel::where('locale', $request->locale)->first();
            if(!$locale){
                $notification = array(
                    'message' => __('language::language.notify.languge_not_found'),
                    'alert-type' => 'warning',
                );
                return redirect()->route('language.index')->with($notification);
            }
            $lang = LangModel::findOrFail($locale->id);
        }
        return view('language::index', compact('lang', 'languageData', 'languages', 'flags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'sltLocale' => 'required',
            'txtDisplayName' => 'required'
        ];
        $messages =  [
            'sltLocale.required' => __('language::language.required.locale'),
            'txtDisplayName.required' => __('language::language.required.display_name')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $language = new LangModel();
        $language->name = $request->txtDisplayName;
        $language->locale = $request->sltLocale;
        $language->status = $request->status;
        $language->created_by = Auth::guard('woo')->user()->id;
        $language->save();
        $notification = array(
            'message' => __('language::language.notify.add_new_success'),
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $locale)
    {

        $rules = [
            'sltLocale' => 'required',
            'txtDisplayName' => 'required'
        ];
        $messages =  [
            'sltLocale.required' => __('language::language.required.locale'),
            'txtDisplayName.required' => __('language::language.required.display_name')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $language = LangModel::where('locale', $locale)->first();
        $language->name = $request->txtDisplayName;
        $language->locale = $request->sltLocale;
        $language->status = $request->status;
        $language->updated_by = Auth::guard('woo')->user()->id;
        $language->save();
        $notification = array(
            'message' => __('language::language.notify.update_success'),
            'alert-type' => 'success',
        );
        return redirect()->route('language.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = LangModel::find($id);
        if($language){
            $language->deleted_at = date('Y-m-d H:i:s', time());
            $language->deleted_by = Auth::guard('woo')->user()->id;
            $language->save();
            return response()->json(['status' => 'success', 'msg' => 'Delete language successfully']);
        }else{
            return response()->json(['status' => 'language-not-found', 'msg' => 'OK']);
        }
    }
}
