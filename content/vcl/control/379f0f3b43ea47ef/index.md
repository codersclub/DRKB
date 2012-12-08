---
Title: Как использовать клавишу-акселератор в TTabSheet?
Date: 01.01.2007
---


Как использовать клавишу-акселератор в TTabSheet?
=================================================

::: {.date}
01.01.2007
:::

Как использовать клавишу-акселератор в TTabsheets? Я добавляю
клавишу-акселератор в заголовок каждого Tabsheet моего PageControl, но
при попытке переключать страницы этой клавишей программа пикает и ничего
не происходит.

Можно перехватить сообщение CM\_DIALOGCHAR.

    type
      TForm1 = class(TForm)
        PageControl1: TPageControl;
        TabSheet1: TTabSheet;
        TabSheet2: TTabSheet;
        TabSheet3: TTabSheet;
      private
      {Private declarations}
        procedure CMDialogChar(var Msg: TCMDialogChar);
          message CM_DIALOGCHAR;
      public
      {Public declarations}
      end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.CMDialogChar(var Msg: TCMDialogChar);
    var
      i: integer;
    begin
      with PageControl1 do
        begin
          if Enabled then
            for i := 0 to PageControl1.PageCount - 1 do
              if ((IsAccel(Msg.CharCode, Pages[i].Caption)) and
                (Pages[i].TabVisible)) then
                begin
                  Msg.Result := 1;
                  ActivePage := Pages[i];
                  exit;
                end;
        end;
      inherited;
    end;

Взято из

DELPHI VCL FAQ Перевод с английского      

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)