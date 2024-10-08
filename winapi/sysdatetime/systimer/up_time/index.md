---
Title: Как долго запущена Windows?
Author: Павел
Date: 01.01.2007
---

Как долго запущена Windows?
===========================

Вариант 1:

Source: <https://forum.sources.ru>

Ниже приведён код обработчика события OnClick для Button1. Он показывает
диалоговое окошко с текстом в следующем формате:

> Windows started on Thursday, February 10, 2000 at 11:42:46 AM
> Its been up for 0 days, 3 hours, 22 minutes, 54 seconds


    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      ndays: double; 
      ticks: LongInt; 
      btime: TDateTime; 
    begin 
      {Функция GetTickCount получает количество миллисекунд,
       прошедших с момента старта Windows}
      ticks := GetTickCount; 
     
      {Чтобы получить дни, необходимо разделить на количество миллисекунд в дне,
       24*60*60*1000=86400000} 
      ndays := ticks/86400000; 
     
      {теперь вычитаем из текущей даты полученное количество дней работы Windows}
      bTime := now-ndays; 
     
      {показываем диалоговое окошко с сообщением}
      ShowMessage( 
       FormatDateTime('"Windows started on" dddd, mmmm d, yyyy, ' + 
                      '"at" hh:nn:ss AM/PM', bTime) + #10#13 + 
                      'Its been up for ' + IntToStr(Trunc(nDays)) + ' days,' +
                      FormatDateTime(' h "hours," n "minutes," s "seconds"',ndays));
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    function UpTime: string;
    const
      ticksperday: Integer    = 1000 * 60 * 60 * 24;
      ticksperhour: Integer   = 1000 * 60 * 60;
      ticksperminute: Integer = 1000 * 60;
      tickspersecond: Integer = 1000;
    var
      t:          Longword;
      d, h, m, s: Integer;
    begin
      t := GetTickCount;
    
      d := t div ticksperday;
      Dec(t, d * ticksperday);
    
      h := t div ticksperhour;
      Dec(t, h * ticksperhour);
    
      m := t div ticksperminute;
      Dec(t, m * ticksperminute);
    
      s := t div tickspersecond;
    
      Result := 'Uptime: ' + IntToStr(d) + ' Days ' +
                IntToStr(h) + ' Hours ' +
                IntToStr(m) + ' Minutes ' +
                IntToStr(s) + ' Seconds';
    end;
    
    
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      label1.Caption := UpTime;
    end;


------------------------------------------------------------------------

Вариант 3:

Author: Павел

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Чтобы определить сколько времени прошло с момента последней перезагрузки
системы необходимо воспользоваться функцией `GetCurrentTime: LongInt;`

Возвращаемое значение: время в миллисекундах.

Пример использования:

    Edit1.Text := FloatToStr(GetCurrentTime / 1000) + ' секунд с момента перезагрузки';

