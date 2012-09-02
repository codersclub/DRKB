<h1>Функции для работы с объектом типа TImage</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функции для работы с объектом типа TImage
 
Модуль ImgTools предоставляет функции для работы с изображениями,
в частности для работы с визуальным объектом типа TImage.
 
Function FitBestSize - Подбор оптимального размера рисунка,
в соответствии с областью на которой он расположен
Function CenterImage - Центрирование рисунка в области, на которой он расположен
Function SetImageSize - Процентное изменение размера рисунка
 
Каждая функция возвращает результат типа TImageSizeParams;
type TImageSizeParams = record
OldImageWidth - ширина рисунка до преобразований
OldImageHeight - высота рисунка до преобразований
OldImageLeft - позиция X рисунка до преобразований
OldImageTop - позиция Y рисунка до преобразований
NewImageWidth - ширина рисунка после преобразований
NewImageHeight - высота рисунка после преобразований
NewImageLeft - позиция X рисунка после преобразований
NewImageTop - позиция Y рисунка после преобразований
NewImageSizePercent - размер рисунка в процентах после преобразования,
от размера рисунка до преобразования
end;
 
Зависимости: ExtCtrls
Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
Copyright:   VID
Дата:        05 мая 2002 г.
***************************************************** }
 
unit ImgTools;
 
interface
 
uses ExtCtrls;
 
type
  TImageSizeParams = record
    OldImgWidth, OldImgHeight, OldImageLeft, OldImageTop,
      NewImgWidth, NewImgHeight, NewImageLeft, NewImageTop,
      NewImgSizePercent: Integer;
  end;
 
type
  TTimeState = (tsBefore, tsAfter);
 
function FitBestSize(Img: TImage): TImageSizeParams;
function CenterImage(Img: TImage): TImageSizeParams;
function SetImageSize(Img: TImage; SizePercent: Integer): TImageSizeParams;
 
var
  ImageSizeParams: TImageSizeParams;
 
implementation
 
//Обнуление полей переменной типа TImageSizeParams
 
function ClearImageSizeParams: TImageSizeParams;
begin
  Result.OldImgWidth := 0;
  Result.OldImgHeight := 0;
  Result.OldImageLeft := 0;
  Result.OldImageTop := 0;
  Result.NewImgWidth := 0;
  Result.NewImgHeight := 0;
  Result.NewImageLeft := 0;
  Result.NewImageTop := 0;
  Result.NewImgSizePercent := 0;
end;
 
//Получение параметров рисунка до и после преобразований
 
function GetImageSizeParams(Img: TImage; TimeState: TTimeState):
  TImageSizeParams;
begin
  if img = nil then
  begin
    result := ClearImageSizeParams;
    ImageSizeParams := Result;
    exit;
  end;
  if TimeState = tsBefore then
  begin
    ImageSizeParams := ClearImageSizeParams;
    result.OldImgWidth := img.Width;
    Result.OldImgHeight := img.Height;
    result.OldImageLeft := img.Left;
    result.OldImageTop := img.Top;
  end;
  if TimeState = tsAfter then
  begin
    Result := ImageSizeParams;
    Result.NewImgWidth := img.Width;
    Result.NewImgHeight := img.Height;
    result.NewImageLeft := img.Left;
    result.NewImageTop := img.Top;
    Result.NewImgSizePercent := Round(Result.NewImgWidth / Result.OldImgWidth *
      100);
  end;
  ImageSizeParams := Result;
end;
 
//Подбор оптимального размера рисунка, в соответствии с областью на которой он расположен
 
function FitBestSize(Img: Timage): TImageSizeParams;
var
  h, w, i, x, y: Integer;
  K, b, a: Double;
begin
  if Img = nil then
    exit;
  try
    Result := ClearImageSizeParams;
    Img.AutoSize := True;
    Img.AutoSize := False;
    GetImageSizeParams(Img, tsBefore);
    h := img.picture.Height;
    w := img.picture.Width;
    i := 0;
    repeat
      x := img.Parent.clientwidth - w;
      y := img.Parent.clientheight - h;
      i := i + 1;
      k := w / h;
      if y &lt; x then
      begin
        b := y;
        h := h + Round(b);
        a := H * k - W;
        w := w + Round(a);
      end;
      if y &gt;= x then
      begin
        a := x;
        w := w + Round(a);
        b := (w / k) - H;
        h := h + Round(b);
      end;
    until (w &lt; img.Parent.width) or (h &lt; img.Parent.height) or (i &gt;= 2);
    img.Stretch := true;
    img.Width := w;
    img.height := h;
    Result := GetImageSizeParams(Img, tsAfter);
  except
  end;
end;
 
//Центрирование рисунка в области, на которой он расположен
 
function CenterImage(Img: TImage): TImageSizeParams;
begin
  Result := ClearImageSizeParams;
  if Img = nil then
    exit;
  GetImageSizeParams(img, tsBefore);
  img.left := (Img.parent.Width div 2) - (img.Width div 2);
  img.Top := (Img.parent.Height div 2) - (img.height div 2);
  Result := GetImageSizeParams(img, tsAfter);
end;
 
//Процентное изменение размера рисунка
 
function SetImageSize(Img: TImage; SizePercent: Integer): TImageSizeParams;
var
  K: Double;
  nw, nh: Integer;
begin
  Result := ClearImageSizeParams;
  if Img = nil then
    exit;
  if SizePercent &lt; 0 then
    exit;
  Img.AutoSize := True;
  Img.AutoSize := False;
  GetImageSizeParams(img, tsBefore);
  try
    K := img.height / img.width;
  except exit;
  end;
  nw := Round(img.Width * SizePercent / 100);
  nh := round(nw * k);
  img.Stretch := true;
  img.Width := nw;
  img.Height := nh;
  Result := GetImageSizeParams(img, tsAfter);
end;
 
end.
</pre>

