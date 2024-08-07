---
Title: Как сделать многострочную надпись на TBitBtn?
Date: 01.01.2007
---


Как сделать многострочную надпись на TBitBtn?
=============================================

Вариант 1:

Выводите текст надписи непосредственно на "glyph" TBitBtn\'а

    procedure TForm1.FormCreate(Sender: TObject);
    var
      R: TRect;
      N: Integer;
      Buff: array[0..255] of Char;
    begin
      with BitBtn1 do
        begin
          Caption := 'A really really long caption';
          Glyph.Canvas.Font := Self.Font;
          Glyph.Width := Width - 6;
          Glyph.Height := Height - 6;
          R := Bounds(0, 0, Glyph.Width, 0);
          StrPCopy(Buff, Caption);
          Caption := '';
          DrawText(Glyph.Canvas.Handle, Buff, StrLen(Buff), R,
            DT_CENTER or DT_WORDBREAK or DT_CALCRECT);
          OffsetRect(R, (Glyph.Width - R.Right) div 2,
            (Glyph.Height - R.Bottom) div 2);
          DrawText(Glyph.Canvas.Handle, Buff, StrLen(Buff), R,
            DT_CENTER or DT_WORDBREAK);
        end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Я создал удобный компонент, инкапсулирующий обычную кнопку, но с
возможностью многострочного заголовка. В *действительности* - это
TBitBtn, чей Glyph *нарисован* в виде заголовка с переносом текста.
Реальный заголовок невидим. Это работает! Попробуйте с этим
поэкспериментировать и сообщите мне о ваших новых находках. Я был
удивлен, что это свойство оказалось легко *подавить*. Тем более, что
это свойство public/published, а не какой-то кот в мешке. Все это так,
но вы можете перекрыть свойство другим с таким же именем и с атрибутом
READ ONLY. И вы можете ссылать на свойство предка, как, например,
"Inherited Glyph". ООП!

    unit C_wrapb;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Buttons;
     
    type
      TWrapBtn = class(TBitBtn)
      private
        { Private declarations }
        function GetGlyph: string;
        function GetMargin: Integer;
        function GetSpacing: Integer;
        function GetKind: TBitBtnKind;
        function GetLayout: TButtonLayout;
        function GetNumGlyphs: TNumGlyphs;
        procedure CMTextChanged(var Message: TMessage);
          message CM_TEXTCHANGED;
        procedure CMFontChanged(var Message: TMessage);
          message CM_FONTCHANGED;
        procedure WMSize(var Msg: TWMSize);
          message WM_SIZE;
        procedure CaptionGlyph;
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        { Published declarations }
        property Glyph: string read GetGlyph;
        property Margin: Integer read GetMargin;
        property Spacing: Integer read GetSpacing;
        property Kind: TBitBtnKind read GetKind;
        property Layout: TButtonLayout read GetLayout;
        property NumGlyphs: TNumGlyphs read GetNumGlyphs;
      end;
     
    procedure Register;
     
    implementation
     
    procedure TWrapBtn.CaptionGlyph;
    var
      GP: TBitmap;
      R: TRect;
      Buff: array[0..255] of Char;
    begin
      GP := TBitmap.Create;
      try
        with GP do
        begin
          Canvas.Font := Self.Font;
          StrPCopy(Buff, Caption);
          inherited Margin := 0;
          inherited Spacing := GetSpacing;
          Width := Self.Width - GetSpacing;
          Height := Self.Height - GetSpacing;
          R := Bounds(0, 0, Width, 0);
          DrawText(Canvas.Handle, Buff, StrLen(Buff), R,
            DT_CENTER or DT_WORDBREAK or DT_CALCRECT);
          OffsetRect(R, (Width - R.Right) div 2,
            (Height - R.Bottom) div 2);
          DrawText(Canvas.Handle, Buff, StrLen(Buff), R,
            DT_CENTER or DT_WORDBREAK);
        end;
        inherited Glyph := GP;
        inherited NumGlyphs := 1;
      finally
        GP.Free;
      end;
    end;
     
    function TWrapBtn.GetGlyph: string;
    begin
      Result := '(Н/Д)';
    end;
     
    procedure TWrapBtn.CMTextChanged(var Message: TMessage);
    begin
      inherited;
      CaptionGlyph;
    end;
     
    procedure TWrapBtn.CMFontChanged(var Message: TMessage);
    begin
      inherited;
      CaptionGlyph;
    end;
     
    procedure TWrapBtn.WMSize(var Msg: TWMSize);
    begin
      inherited;
      CaptionGlyph;
    end;
     
    function TWrapBtn.GetMargin: Integer;
    begin
      Result := 0;
    end;
     
    function TWrapBtn.GetSpacing: Integer;
    begin
    {$IFDEF Win32}
      Result := 12;
    {$ELSE}
      Result := 6;
    {$ENDIF}
    end;
     
    function TWrapBtn.GetKind: TBitBtnKind;
    begin
      Result := bkCustom;
    end;
     
    function TWrapBtn.GetLayout: TButtonLayout;
    begin
      Result := blGlyphLeft;
    end;
     
    function TWrapBtn.GetNumGlyphs: TNumGlyphs;
    begin
      Result := 1;
    end;
     
    procedure Register;
    begin
      RegisterComponents('FAQ', [TWrapBtn]);
    end;
     
    end.


