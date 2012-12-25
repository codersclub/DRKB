---
Title: Как работать с джойстиком?
Date: 01.01.2007
---


Как работать с джойстиком?
==========================

::: {.date}
01.01.2007
:::

    uses MMSYSTEM; 
    var 
      MyJoy: TJoyInfo; 
      ErrorResult: MMRESULT; 
    begin 
      ErrorResult := joyGetPos(joystickid1, @MyJoy); 
      if ErrorResult = JOYERR_NOERROR then 
      begin 
        TrackBar1.Position := MyJoy.wypos; 
        TrackBar2.Position := MyJoy.wxpos; 
        RadioButton1.Checked := (MyJoy.wbuttons and joy_button1) > 0; 
        RadioButton2.Checked := (MyJoy.wbuttons and joy_button2) > 0; 
      end  
    else 
       case ErrorResult of 
         MMSYSERR_NODRIVER: ShowMessage('No Joystick driver present'); 
         MMSYSERR_INVALPARAM: ShowMessage('Invalid Joystick Paramameters'); 
         JOYERR_UNPLUGGED: ShowMessage('Joystick is Unplugged'); 
       else  
         ShowMessage('Unknown error with Joystick'); 
     end; 
     
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    var
      myjoy: tjoyinfo;
    begin
      joygetpos(joystickid1, @myjoy);
      trackbar1.position := myjoy.wypos;
      trackbar2.position := myjoy.wxpos;
      radiobutton1.checked := (myjoy.wbuttons and joy_button1) > 0;
      radiobutton2.checked := (myjoy.wbuttons and joy_button2) > 0;
    end;

Не забудьте включить MMSYSTEM в список используемых (USES) модулей

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
