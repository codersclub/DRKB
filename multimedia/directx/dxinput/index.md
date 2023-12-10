---
Title: DXInput
Author: Daddy
Date: 01.01.2007
---


DXInput
=======

::: {.date}
01.01.2007
:::

Автор: Daddy

WEB-сайт: http://daddy.mirgames.ru

В этой статье мы рассмотрим методы управления объектами в играх с
помощью клавиатуры, мыши и джойстика..

1. Клавиатура.

Опрос нажатия клавиши ведется через DXInput.States:

    if <тикер> in DXInput.States then
    begin
       //действие
    end

,где

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------
  ·   \<тикер\> есть зарезервированное слово:
  --- -----------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------------------
  ·   isUp - по умолчанию \"стрелка вверх\"
  --- ---------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------------------
  ·   isDown - по умолчанию \"стрелка вниз\"
  --- ----------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------------------------
  ·   isRight - по умолчанию \"стрелка вправо\"
  --- -------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------
  ·   isLeft - по умолчанию \"стрелка влево\"
  --- -----------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------
  ·   IsButton1 - по умолчанию \"Space\"
  --- ------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------
  ·   IsButton2 - по умолчанию \"Enter\"
  --- ------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------------------------------
  ·   IsButton3-IsButton32 - по умолчанию не определены
  --- ---------------------------------------------------
:::

Для сравнения два равноценных условия:

    //c использования DXInput
    if isUp in DXInput.States then
    begin
    //действие
    end  //а это - без
    if Key=VK_UP then
    begin
    //действие
    end

Чтобы определить \"тикер\": DXInput.Keyboard.KeyAssigns\[\<тикер\>,X\]:=
\<кнопка\> ,где:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------------------------
  ·   X - значение от 0 до 2 (то есть на каждый \"тикер\" можно присвоить до трех \<кнопок\>)
  --- -----------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------
  ·   \<кнопка\> - код кнопки (например ord(\'Q\')).
  --- ------------------------------------------------
:::

Примечание: буквенные клавиши указываются в верхнем регистре, т.е.

DXInput.Keyboard.KeyAssigns\[isButton10,X\]:=ord(\'q\')

не будет реагировать на нажатие клавиши \'q\' .

Кнопки Ctrl, Alt, Shift можно опросить обычным способом:

    If (ssCtrl in Shift) then ...
    If (ssAlt in Shift) then ...
    If (ssShift in Shift) then ...

Небольшой примерчик. Зарекрепим за тикером isUp - кнопки \"E\",\"I\" и
\"стрелка вверх\":

     
    procedure TForm1.DXTimerTimer(Sender: TObject; LagCount: Integer);
    begin
       if not DXDraw.CanDraw then exit;
       //обновим состояние DXInput (нужно делать при каждом тике таймера)
       DXInput.Update;
       DXDraw.Surface.Fill(0);
       If isUP in DXInput.States then
          With DXDraw.Surface.Canvas do
          begin
             Brush.Style := bsClear;
             Font.Color := clWhite;
             Font.Size := 12;
             TextOut(50,50,'UP pressed');
             Release;
          end;
       DXDraw.Flip;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
       DXInput.Keyboard.KeyAssigns[isUp,0]:=ord('E');
       //за [isUp,1] - по умолчанию зарезервирована "стрелка вверх", оставим ее.
       DXInput.Keyboard.KeyAssigns[isUp,2]:=ord('I');
    end;

2\. Мышь

DXinput.Mouse.X - положение курсора по горизонтали
DXinput.Mouse.Y - положение курсора по вертикали
DXinput.Mouse.Z - положение курсора по третьей оси


Небольшой примерчик:

    var
       Form1: TForm1;
       MouseX,MouseY:integer;
       LeftB,RightB:boolean;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.DXTimerTimer(Sender: TObject; LagCount: Integer);
    var Shift: TShiftState;
    begin
       if not DXDraw.CanDraw then exit;
       DXInput.Update;
       DXDraw.Surface.Fill(0);
       With DXDraw.Surface.Canvas do
       begin
          Brush.Style := bsClear;
          Font.Color := clWhite;
          Font.Size := 12;
          If LeftB then
             TextOut(0,0,'Left');
          If RightB then
             TextOut(50,0,'Right');
          TextOut(0,50,IntToStr(MouseX)+','+IntToStr(MouseY));
          Release;
       end;
       DXDraw.Flip;
    end;
     
    procedure TForm1.DXDrawMouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
    begin
       MouseX:=X;
       MouseY:=Y;
    end;
     
    procedure TForm1.DXDrawMouseDown(Sender: TObject; Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
       If ssLeft in Shift then LeftB:=true;
       If ssRight in Shift then RightB:=true;
    end;
     
    procedure TForm1.DXDrawMouseUp(Sender: TObject; Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
       LeftB:=false; RightB:=false;
    end;

3\. Джойстик

Настроим джойстик:
DXinput.Joystick.RangeX = 0 - 1000, устанавливает диапазон изменения
значений по горизонтальной оси от X до -X
DXinput.Joystick.RangeY = 0 - 1000, устанавливает диапазон изменения
значений по вертикальной оси от Y до -Y
DXinput.Joystick.RangeZ = 0 - 1000, устанавливает диапазон изменения
значений по третьей оси от Z до -Z

DXinput.Joystick.DeadzoneX = 0 - 100, устанавливает чувствительность по
горизонтальной оси
DXinput.Joystick.DeadzoneY = 0 - 100, устанавливает чувствительность по
вертикальной оси
DXinput.Joystick.DeadzoneZ = 0 - 100, устанавливает чувствительность по
третьей оси
0 - самое чувствительное значение.

Читаем положение рукоятки:
DXinput.Joystick.X - по горизонтальной оси
DXinput.Joystick.Y - по вертикальной оси
DXinput.Joystick.Z - по третьей оси


Z - используется в случае наличия на джойстике соответствующей ручки.
Этот кусок кода сканирует кнопки на джойстике:

    for i := 0 to DXInput1.Joystick.ButtonCount do
    begin
       if DXInput1.Joystick.Buttons[i] = True then
       begin
          //Кнопка нажата. Действие.
       end;
    end;

Примечание: Руль можно считать частным случаем джойстика. При этом
штурвал - горизонтальная ось (X), педаль газа и педаль тормоза -
вертикальная ось (Y).

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
