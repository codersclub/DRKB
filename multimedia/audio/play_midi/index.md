---
Title: Как играть MIDI без медиаплеера?
Date: 01.01.2007
---


Как играть MIDI без медиаплеера?
================================

::: {.date}
01.01.2007
:::

    uses 
      MMSystem; 
     
    // Play Midi 
    procedure TForm1.Button1Click; 
    const 
      FileName = 'C:\YourFile.mid'; 
    begin 
      MCISendString(PChar('play ' + FileName), nil, 0, 0); 
    end; 
     
    // Stop Midi 
    procedure TForm1.Button1Click; 
    const 
      FileName = 'C:\YourFile.mid'; 
    begin 
      MCISendString(PChar('stop ' + FileName), nil, 0, 0); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
