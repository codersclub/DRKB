---
Title: Перевести секунды в формат времени
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перевести секунды в формат времени
==================================

    const 
      SecPerDay = 86400; 
      SecPerHour = 3600; 
      SecPerMinute = 60; 
     
    function SecondToTime(const Seconds: Cardinal): Double; 
    var 
      ms, ss, mm, hh, dd: Cardinal; 
    begin 
      dd := Seconds div SecPerDay; 
      hh := (Seconds mod SecPerDay) div SecPerHour; 
      mm := ((Seconds mod SecPerDay) mod SecPerHour) div SecPerMinute; 
      ss := ((Seconds mod SecPerDay) mod SecPerHour) mod SecPerMinute; 
      ms := 0; 
      Result := dd + EncodeTime(hh, mm, ss, ms); 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      label1.Caption := DateTimeToStr(Date + SecondToTime(86543)); 
    end; 



 
