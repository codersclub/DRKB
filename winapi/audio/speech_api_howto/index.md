---
Title: Как использовать Microsoft Speech API?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как использовать Microsoft Speech API?
======================================

    // Works on NT, 2k, XP, Win9x with SAPI SDK
    // reference & Further examples: See links below!
     
    uses Comobj;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      voice: OLEVariant;
    begin
      voice := CreateOLEObject('SAPI.SpVoice');
      voice.Speak('Hello World!', 0);
    end;

