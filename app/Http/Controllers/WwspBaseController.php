<?php

namespace App\Http\Controllers;

class WwspBaseController extends Controller
{
  public function fileUpload($request, $fileFieldName, $uploadPath, $fileValidationRules, $singleOrMultiple = 'single')
  {
    $uploadedFiles = [];

    $this->validate($request, $fileValidationRules);

    if ($singleOrMultiple === 'single') {
      $theFile = $request->$fileFieldName;
      if ($theFile->isValid()) {

        $savedFilePath = $theFile->store($uploadPath, 'uploads');
        $savedFileName = str_replace($uploadPath . "/", "", $savedFilePath);
        $uploadedFiles[] = [
          'fileName' => $savedFileName,
        ];
      }
    } else if ($singleOrMultiple === 'multiple') {
      foreach ($request->$fileFieldName as $theFile) {
        if ($theFile->isValid()) {

          $savedFilePath = $theFile->store($uploadPath, 'uploads');
          $savedFileName = str_replace($uploadPath . "/", "", $savedFilePath);
          $uploadedFiles[] = [
            'fileName' => $savedFileName,
          ];
        }
      }
    }

    return $uploadedFiles;
  }
}
