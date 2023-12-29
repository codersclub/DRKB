---
Title: Как вывести текст, написанный под углом или вращение текста?
Author: Pegas
Date: 01.01.2007
---


Как вывести текст, написанный под углом или вращение текста?
============================================================

::: {.date}
01.01.2007
:::

Для того чтобы вывести текст под углом, вытянуть или сжать его нужно
воспользоваться структурой LOGFONT. Здесь показаны не все ее
возможности, но, на мой взгляд, самые интересные.

    procedure TForm1.FormPaint(Sender: TObject);
    var
      lf: TLogFont;
    begin
      FillChar(lf, SizeOf(lf), 0);
      with lf do begin
        // Высота буквы
        lfHeight := 15;
     
        // Ширина буквы
        lfWidth := 20;
     
        // Угол наклона в десятых градуса
        lfEscapement := 100;
     
         // Жирность 0..1000, 0 - по умолчанию
        lfWeight := 1000;
     
        // Курсив
        lfItalic := 0;
     
        // Подчеркнут
        lfUnderline := 1;
     
        // Зачеркнут
        lfStrikeOut := 1;
     
        // CharSet
        lfCharSet := RUSSIAN_CharSet;
     
        // Название шрифта
        StrCopy(lfFaceName, 'Arial');
      end;
      with Form1.Canvas do begin
        FillRect(ClipRect);
        Font.Handle := CreateFontIndirect(lf);
        TextOut(0, 100, 'It is a text string');
      end;
    end;
     

Автор: Pegas

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    { Эта процедура устанавливает угол вывода текста для указанного Canvas, угол в градусах }
    { Шрифт должен быть TrueType ! }
    procedure CanvasSetTextAngle(c: TCanvas; d: single);
    var   LogRec: TLOGFONT;     { Информация о шрифте }
    begin
     {Читаем текущюю инф. о шрифте }
     GetObject(c.Font.Handle,SizeOf(LogRec),Addr(LogRec) );
     { Изменяем угол }
     LogRec.lfEscapement := round(d*10);
     { Устанавливаем новые параметры }
     c.Font.Handle := CreateFontIndirect(LogRec);
    end;

Зайцев О.В.

Владимиров А.М.

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure TextOutAngle(x,y,aAngle,aSize: integer; txt: string); 
    var hFont, Fontold: integer; 
        DC: hdc; 
        Fontname: string; 
    begin 
      if length(txt)= 0 then 
        EXIT; 
      DC:= Screen.ActiveForm.Canvas.handle; 
      SetBkMode(DC, transparent); 
      Fontname:= Screen.ActiveForm.Canvas.Font.Name; 
      hFont:= CreateFont(-aSize,0, aAngle*10,0, fw_normal,0, 0, 
                         0,1,4,$10,2,4,PChar(Fontname)); 
      Fontold:= SelectObject(DC, hFont); 
      TextOut(DC,x,y,PChar(txt), length(txt)); 
      SelectObject(DC, Fontold); 
      DeleteObject(hFont); 
    end; 

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure AngleTextOut(CV: TCanvas; const sText:
      string; x, y, angle: integer);
    var
      LogFont: TLogFont;
      SaveFont: TFont;
    begin
      SaveFont := TFont.Create;
      SaveFont.Assign(CV.Font);
      GetObject(SaveFont.Handle, sizeof(TLogFont), @LogFont);
      with LogFont do
      begin
        lfEscapement := angle * 10;
        lfPitchAndFamily := FIXED_PITCH or FF_DONTCARE;
      end; {with}
      CV.Font.Handle := CreateFontIndirect(LogFont);
      SetBkMode(CV.Handle, TRANSPARENT);
      CV.TextOut(x, y, sText);
      CV.Font.Assign(SaveFont);
      SaveFont.Free;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    procedure TextOutVertical(var bitmap: TBitmap; x, y: Integer; s: string);
    var
      b1, b2: TBitmap;
      i, j: Integer;
    begin
      with bitmap.Canvas do
      begin
        b1 := TBitmap.Create;
        b1.Canvas.Font := lpYhFont;
        b1.Width := TextWidth(s) + 1;
        b1.Height := TextHeight(s) + 1;
        b1.Canvas.TextOut(1, 1, s);
     
        b2 := TPackedBitmap.Create;
        b2.Width := TextHeight(s);
        b2.Height := TextWidth(s);
        for i := 0 to b1.Width - 1 do
          for j := 0 to b1.Height do
            b2.Canvas.Pixels[j, b2.Height + 1 - i] := b1.Canvas.Pixels[i, j];
        Draw(x, y, b2);
        b1.Free;
        b2.Free;
      end
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Некоторое время я делал так: я создавал шрифт, выбирал его в DC ...

    function CreateMyFont(degree: Integer): HFONT;
    begin
      CreateMyFont := CreateFont(
      -30, 0, degree, 0, 0,
      0, 0, 0, 1, OUT_TT_PRECIS,
      0, 0, 0, szFontName);
    end;

.... и затем использовал любую функцию рисования для вывода текста.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Попробуйте это:

    procedure TForm1.TextUp(aRect:tRect;aTxt:String);
    var 
      LFont: TLogFont; 
      hOldFont, hNewFont: HFont;
    begin
      GetObject(Canvas.Font.Handle,SizeOf(LFont),Addr(LFont));
      LFont.lfEscapement := 900;
      hNewFont := CreateFontIndirect(LFont);
      hOldFont := SelectObject(Canvas.Handle,hNewFont);
      Canvas.TextOut(aRect.Left+2,aRect.Top,aTxt);
      hNewFont := SelectObject(Canvas.Handle,hOldFont);
      DeleteObject(hNewFont);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Выводим цветной текст на форме под любым углом

Пример демонстрирует вывод теста случайным образом на форме под
определённым углом. Добавляем в форму компонент TButton и в событие
OnClick следующий код:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      logfont: TLogFont;
      font: Thandle;
      count: integer;
    begin
      LogFont.lfheight := 20;
      logfont.lfwidth := 20;
      logfont.lfweight := 750;
      LogFont.lfEscapement := -200;
      logfont.lfcharset := 1;
      logfont.lfoutprecision := out_tt_precis;
      logfont.lfquality := draft_quality;
      logfont.lfpitchandfamily := FF_Modern;
     
      font := createfontindirect(logfont);
     
      SelectObject(Form1.canvas.handle, font);
     
      SetTextColor(Form1.canvas.handle, rgb(0, 0, 200));
      SetBKmode(Form1.canvas.handle, transparent);
     
      for count := 1 to 10 do
      begin
        Canvas.TextOut(Random(form1.width), Random(form1.height), 'Delphi World');
        SetTextColor(form1.canvas.handle, rgb(Random(255), Random(255), Random(255)));
      end;
     
      DeleteObject(font);
    end;

------------------------------------------------------------------------

    {Create a rotated font based on the font object F}
    function CreateRotatedFont(F : TFont; Angle : Integer) : hFont;
    var
      LF: TLogFont;
    begin
      FillChar(LF, SizeOf(LF), #0);
      with LF do
      begin
        lfHeight := F.Height;
        lfWidth := 0;
        lfEscapement := Angle*10;
        lfOrientation := 0;
        if fsBold in F.Style then
          lfWeight := FW_BOLD
        else
          lfWeight := FW_NORMAL;
        lfItalic := Byte(fsItalic in F.Style);
        lfUnderline := Byte(fsUnderline in F.Style);
        lfStrikeOut := Byte(fsStrikeOut in F.Style);
        lfCharSet := DEFAULT_CHARSET;
        StrPCopy(lfFaceName, F.name);
        lfQuality := DEFAULT_QUALITY;
        {everything else as default}
        lfOutPrecision := OUT_DEFAULT_PRECIS;
        lfClipPrecision := CLIP_DEFAULT_PRECIS;
        case F.Pitch of
          fpVariable: lfPitchAndFamily := VARIABLE_PITCH;
          fpFixed: lfPitchAndFamily := FIXED_PITCH;
          else
            lfPitchAndFamily := DEFAULT_PITCH;
        end;
      end;
      Result := CreateFontIndirect(LF);
    end;
     
    ...
     
    {create the rotated font}
    if FontAngle <> 0 then
      Canvas.Font.Handle := CreateRotatedFont(Font, FontAngle);
    ...
     
     

Вращаются только векторные шрифты.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
