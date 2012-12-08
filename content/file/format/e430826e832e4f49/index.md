---
Title: BMP \> JPG
Date: 01.01.2007
---


BMP \> JPG
==========

::: {.date}
01.01.2007
:::

    uses 
      Jpeg, ClipBrd; 
     
    procedure TfrmMain.ConvertBMP2JPEG; 
      // converts a bitmap, the graphic of a TChart for example, to a jpeg 
    var  
      jpgImg: TJPEGImage; 
    begin 
      // copy bitmap to clipboard 
      chrtOutputSingle.CopyToClipboardBitmap; 
      // get clipboard and load it to Image1 
      Image1.Picture.Bitmap.LoadFromClipboardFormat(cf_BitMap, 
        ClipBoard.GetAsHandle(cf_Bitmap), 0); 
      // create the jpeg-graphic 
      jpgImg := TJPEGImage.Create; 
      // assign the bitmap to the jpeg, this converts the bitmap 
      jpgImg.Assign(Image1.Picture.Bitmap); 
      // and save it to file 
      jpgImg.SaveToFile('TChartExample.jpg'); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
