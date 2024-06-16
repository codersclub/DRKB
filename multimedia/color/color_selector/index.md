---
Title: Как выбрать цвет пользуя TTrackBar?
Date: 01.01.2007
---


Как выбрать цвет пользуя TTrackBar?
===================================

Вариант 1:

- Drop three TrackBars on a form.
- Set Min to 0, Max to 255.
- Drop a TImage on the form.
- Then try this code:

```delphi
{ ... }
var
  Form1: TForm1;
  MyColor: LongWord;
  RedColor: LongWord = $00000000;
  GreenColor: LongWord = $00000000;
  BlueColor: LongWord = $00000000;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  DoImageFill;
end;
 
procedure TForm1.DoImageFill;
begin
  MyColor := RedColor or GreenColor or BlueColor;
  Image1.Canvas.Brush.Color := TColor(MyColor);
  Image1.Canvas.FillRect(Rect(0, 0, Image1.Width, Image1.Height));
end;
 
procedure TForm1.RedBarChange(Sender: TObject);
begin
  RedColor := RedBar.Position;
  DoImageFill;
end;
 
procedure TForm1.GreenBarChange(Sender: TObject);
begin
  GreenColor := GreenBar.Position shl 8;
  DoImageFill;
end;
 
procedure TForm1.BlueBarChange(Sender: TObject);
begin
  BlueColor := BlueBar.Position shl 16;
  DoImageFill;
end;
 
end.
```

------------------------------------------------------------------------

Вариант 2:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

Each color value ranges from 0 to 255.
Set the three trackbars with this range.
You can use the RGB function to create a color from these values.

    { ... }
    type
      TForm1 = class(TForm)
        redTrackBar: TTrackBar;
        greenTrackBar: TTrackBar;
        blueTrackBar: TTrackBar;
        Panel1: TPanel;
        procedure blueTrackBarChange(Sender: TObject);
        procedure greenTrackBarChange(Sender: TObject);
        procedure redTrackBarChange(Sender: TObject);
      public
        { Public declarations }
        procedure ChangeColor;
      end;
     
    procedure TForm1.ChangeColor;
    begin
      Panel1.Color := RGB(redTrackBar.Position, greenTrackBar.Position, blueTrackBar.Position);
    end;
     
    procedure TForm1.blueTrackBarChange(Sender: TObject);
    begin
      ChangeColor;
    end;
     
    procedure TForm1.greenTrackBarChange(Sender: TObject);
    begin
      ChangeColor;
    end;
     
    procedure TForm1.redTrackBarChange(Sender: TObject);
    begin
      ChangeColor;
    end;

