---
Title: Можно ли изменить вид текстового курсора (каретки) edit\'а или другого элемента?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Можно ли изменить вид текстового курсора (каретки) edit\'а или другого элемента?
================================================================================

Вариант 1:

Можно!

В примере показано как создать два цветных "bitmap\'а":
"улыбчивый" и "хмурый" и присвоить их курсору edit\'а. Для этого
нужно перехватить оконную процедуру edit\'а. Чтобы сделать это заменим
адрес оконной процедуры Edit\'а нашим собственным, а старую оконную
процедуру будем вызывать по необходимости. Пример показывает
"улыбчивый" курсор при наборе текста и "хмурый" при забое клавишей
backspace.

    unit caret1;
     
    interface
     
    {$IFDEF WIN32}
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
    {$ELSE}
    uses
      WinTypes, WinProcs, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
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
     
    function NewWindowProc(WindowHandle: hWnd; TheMessage: WParameter; ParamW: WParameter;
      ParamL: LParameter): LongInt
    {$IFDEF WIN32} stdcall; {$ELSE}; export; {$ENDIF}
    begin
    {Call the old edit controls windows procedure}
      NewWindowProc := CallWindowProc(Form1.OldEditsWindowProc, WindowHandle,
        TheMessage, ParamW, ParamL);
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
      CaretBm.Canvas.Font.Name := 'WingDings';
      CaretBm.Canvas.Font.Height := Edit1.Font.Height;
      CaretBm.Canvas.Font.Color := clWhite;
      CaretBm.Width := CaretBm.Canvas.TextWidth('J') + 2;
      CaretBm.Height := CaretBm.Canvas.TextHeight('J') + 2;
      CaretBm.Canvas.Brush.Color := clBlue;
      CaretBm.Canvas.FillRect(Rect(0, 0, CaretBm.Width, CaretBm.Height));
      CaretBm.Canvas.TextOut(1, 1, 'J');
    {Create a frowming bitmap using the wingdings font}
      CaretBmBk := TBitmap.Create;
      CaretBmBk.Canvas.Font.Name := 'WingDings';
      CaretBmBk.Canvas.Font.Height := Edit1.Font.Height;
      CaretBmBk.Canvas.Font.Color := clWhite;
      CaretBmBk.Width := CaretBmBk.Canvas.TextWidth('L') + 2;
      CaretBmBk.Height := CaretBmBk.Canvas.TextHeight('L') + 2;
      CaretBmBk.Canvas.Brush.Color := clBlue;
      CaretBmBk.Canvas.FillRect(Rect(0, 0, CaretBmBk.Width, CaretBmBk.Height));
      CaretBmBk.Canvas.TextOut(1, 1, 'L');
    {Hook the edit controls window procedure}
      OldEditsWindowProc := Pointer(SetWindowLong(Edit1.Handle, GWL_WNDPROC,
        LongInt(@NewWindowProc)));
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
    {Unhook the edit controls window procedure and clean up}
      SetWindowLong(Edit1.Handle, GWL_WNDPROC, LongInt(OldEditsWindowProc));
      CaretBm.Free;
      CaretBmBk.Free;
    end;

------------------------------------------------------------------------

Вариант 2:

    {
      The example below demonstrates creating custom caret:
    }
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        Image1: TImage;
        Edit1: TEdit;
        procedure Memo1MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Edit1MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Memo1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      CreateCaret(Memo1.Handle, Image1.Picture.Bitmap.Handle, 0, 0);
      ShowCaret(Memo1.Handle);
    end;
     
    procedure TForm1.Edit1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      CreateCaret(Edit1.Handle, 0, 10, 4);
      ShowCaret(Edit1.Handle);
    end;
     
    end.

    {The form file source (*.dfm) }
     
      object Form1: TForm1
        Left = 192
        Top = 107
        Width = 544
        Height = 375
        Caption = 'Form1'
        Color = clBtnFace
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        OldCreateOrder = False
        PixelsPerInch = 96
        TextHeight = 13
        object Image1: TImage
          Left = 12
          Top = 4
          Width = 16
          Height = 16
          AutoSize = True
          Picture.Data = {  
          07544269746D6170B6020000424DB602000000000000B6000000280000001000  
          0000100000000100100000000000000200000000000000000000100000000000  
          000000000000000080000080000000808000800000008000800080800000C0C0  
          C000808080000000FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFF  
          FF00000000000000000000000000000000000000000000000000000000000000  
          0000000000000000000000000000000000000000000000000000000000000000  
          000000000000FF7FFF7FFF7FFF7F000000000000FF7FFF7FFF7FFF7FFF7FFF7F  
          00000000FF7FFF7FFF7FFF7F000000000000FF7FFF7FFF7FFF7FFF7FFF7F0000  
          0000FF7FFF7FFF7FFF7FFF7F00000000FF7FFF7FFF7FFF7FFF7FFF7FFF7F0000  
          000000000000FF7FFF7FFF7F0000000000000000FF7FFF7FFF7FFF7F00000000  
          0000000000000000FF7FFF7FFF7FFF7FFF7FFF7FFF7FFF7FFF7FFF7F00000000  
          0000000000000000FF7FFF7FFF7FFF7FFF7FFF7FFF7FFF7FFF7F000000000000  
          0000000000000000FF7FFF7FFF7F00000000FF7FFF7FFF7FFF7F000000000000  
          00000000000000000000FF7FFF7FFF7FFF7FFF7FFF7FFF7F0000000000000000  
          00000000000000000000FF7FFF7FFF7FFF7FFF7FFF7FFF7F0000000000000000  
          000000000000000000000000FF7FFF7FFF7FFF7FFF7FFF7F0000000000000000  
          000000000000000000000000FF7FFF7FFF7FFF7FFF7F00000000000000000000  
          0000000000000000000000000000FF7FFF7FFF7FFF7F00000000000000000000  
          0000000000000000000000000000FF7FFF7FFF7F000000000000000000000000  
          00000000000000000000000000000000FF7F0000000000000000000000000000  
          0000}
        end
        object Memo1: TMemo
          Left = 12
          Top = 36
          Width = 149
          Height = 149
          Lines.Strings = ('Memo1')
          TabOrder = 0
          OnMouseDown = Memo1MouseDown
        end
        object Edit1: TEdit
          Left = 220
          Top = 60
          Width = 121
          Height = 21
          TabOrder = 1
          Text = 'Edit1'
          OnMouseDown = Edit1MouseDown
        end
      end

