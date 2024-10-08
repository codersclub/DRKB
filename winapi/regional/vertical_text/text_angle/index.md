---
Title: Как выдать текст под наклоном?
Date: 01.01.2007
---

Как выдать текст под наклоном?
==============================

Вариант 1:

Чтобы вывести под любым углом текст необходимо использовать TrueType
Fonts (например "Arial"). Например:

    var
     
      LogFont : TLogFont;
     
    ...
      GetObject(Canvas.Font.Handle, SizeOf(TLogFont), @LogFont);
      { Вывести текст 1/10 градуса против часовой стрелки }
     
     
      LogFont.lfEscapement := Angle*10; 
      Canvas.Font.Handle := CreateFontIndirect(LogFont);

------------------------------------------------------------------------

Вариант 2:

    { Эта процедура устанавливает угол вывода текста
    для указанного Canvas, угол в градусах
    Шрифт должен быть TrueType }
    procedure CanvasSetTextAngle(c: TCanvas; d: single);
    var
      LogRec: TLOGFONT; { Информация о шрифте }
    begin
      {Читаем текущюю инф. о шрифте }
      GetObject(c.Font.Handle,SizeOf(LogRec),Addr(LogRec) );
      { Изменяем угол }
      LogRec.lfEscapement := round(d*10);
      { Устанавливаем новые параметры }
      c.Font.Handle := CreateFontIndirect(LogRec);
    end;

------------------------------------------------------------------------

Вариант 3:

    procedure TextOutAngle(x,y,aAngle,aSize: integer; txt: string);
    var
      hFont, Fontold: integer;
      DC: hdc;
      Fontname: string;
    begin
      if length(txt) = 0 then
        Exit;
      DC:= Screen.ActiveForm.Canvas.handle;
      SetBkMode(DC, transparent);
      Fontname:= Screen.ActiveForm.Canvas.Font.name;
      hFont:= CreateFont(-aSize,0, aAngle*10,0, fw_normal,0, 0,
      0,1,4,$10,2,4,PChar(Fontname));
      Fontold:= SelectObject(DC, hFont);
      TextOut(DC,x,y,PChar(txt), length(txt));
      SelectObject(DC, Fontold);
      DeleteObject(hFont);
    end;

------------------------------------------------------------------------

Вариант 4:

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

Вариант 5:

Source: <https://delphiworld.narod.ru>

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

