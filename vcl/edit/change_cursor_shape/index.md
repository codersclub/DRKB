---
Title: Изменить вид каретки TEdit
Date: 01.01.2007
---


Изменить вид каретки TEdit
==========================

::: {.date}
01.01.2007
:::

В примере показано как создать два цветных "bitmap\'а": "улыбчивый"
и "хмурый" и присвоить их курсору edit\'а.

Для этого нужно перехватить
оконную процедуру edit-а. Чтобы сделать это заменим адрес оконной
процедуры Edit\'а нашим собственным, а старую оконную процедуру будем
вызывать по необходимости. Пример показывает "улыбчивый" курсор при
наборе текста и "хмурый" при забое клавишей backspace.

    unit caret1;
     
    interface
     
    {$IFDEF WIN32}
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
    {$ELSE}
    uses
      WinTypes, WinProcs, Messages, SysUtils, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls;
    {$ENDIF}
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        private
          {Private declarations}
        public
          {Public declarations}
          CaretBm: TBitmap;
          CaretBmBk: TBitmap;
          OldEditsWindowProc: Pointer;
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    type
      {$IFDEF WIN32}
      WParameter = LongInt;
      {$ELSE}
      WParameter = Word;
      {$ENDIF}
      LParameter = LongInt;
     
    {New windows procedure for the edit control}
    function NewWindowProc(WindowHandle : hWnd;
    TheMessage : WParameter; ParamW : WParameter;
    ParamL : LParameter) : LongInt
    {$IFDEF WIN32} stdcall; {$ELSE} ; export; {$ENDIF}
    begin
      {Call the old edit controls windows procedure}
      NewWindowProc := CallWindowProc(Form1.OldEditsWindowProc,
      WindowHandle, TheMessage, ParamW, ParamL);
      if TheMessage = WM_SETFOCUS then
      begin
        CreateCaret(WindowHandle, Form1.CaretBm.Handle, 0, 0);
        ShowCaret(WindowHandle);
      end;
      if TheMessage = WM_KILLFOCUS then
      begin
        HideCaret(WindowHandle);
        DestroyCaret;
      end;
      if TheMessage = WM_KEYDOWN then
      begin
        if ParamW = VK_BACK then
          CreateCaret(WindowHandle, Form1.CaretBmBk.Handle, 0, 0)
        else
          CreateCaret(WindowHandle, Form1.CaretBm.Handle, 0, 0);
        ShowCaret(WindowHandle);
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {Create a smiling bitmap using the wingdings font}
      CaretBm := TBitmap.Create;
      CaretBm.Canvas.Font.name := 'WingDings';
      CaretBm.Canvas.Font.Height := Edit1.Font.Height;
      CaretBm.Canvas.Font.Color := clWhite;
      CaretBm.Width := CaretBm.Canvas.TextWidth('J') + 2;
      CaretBm.Height := CaretBm.Canvas.TextHeight('J') + 2;
      CaretBm.Canvas.Brush.Color := clBlue;
      CaretBm.Canvas.FillRect(Rect(0, 0, CaretBm.Width,
      CaretBm.Height));
      CaretBm.Canvas.TextOut(1, 1, 'J');
      {Create a frowming bitmap using the wingdings font}
      CaretBmBk := TBitmap.Create;
      CaretBmBk.Canvas.Font.name := 'WingDings';
      CaretBmBk.Canvas.Font.Height := Edit1.Font.Height;
      CaretBmBk.Canvas.Font.Color := clWhite;
      CaretBmBk.Width := CaretBmBk.Canvas.TextWidth('L') + 2;
      CaretBmBk.Height := CaretBmBk.Canvas.TextHeight('L') + 2;
      CaretBmBk.Canvas.Brush.Color := clBlue;
      CaretBmBk.Canvas.FillRect(Rect(0,0, CaretBmBk.Width,
      CaretBmBk.Height));
      CaretBmBk.Canvas.TextOut(1, 1, 'L');
      {Hook the edit controls window procedure}
      OldEditsWindowProc := Pointer(SetWindowLong(Edit1.Handle,
      GWL_WNDPROC, LongInt(@NewWindowProc)));
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      {Unhook the edit controls window procedure and clean up}
      SetWindowLong(Edit1.Handle,GWL_WNDPROC,
      LongInt(OldEditsWindowProc));
      CaretBm.Free;
      CaretBmBk.Free;
    end;
     
    end. 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
