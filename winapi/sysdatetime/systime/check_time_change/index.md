---
Title: Как определить, изменилось ли системное время?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как определить, изменилось ли системное время?
==============================================

Следующий пример демонстрирует обработку сообщения WM\_TIMECHANGE.
Приложение, которое изменяет системное время, посылает сообщение
WM\_TIMECHANGE всем окнам верхнего уровня.

    type 
      TForm1 = class(TForm) 
    private 
    { Private declarations } 
      procedure WMTIMECHANGE(var Message: TWMTIMECHANGE);
                message WM_TIMECHANGE; 
    public 
    { Public declarations } 
    end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.WMTIMECHANGE(var Message: TWMTIMECHANGE); 
    begin 
      Form1.Caption := 'Time Changed'; 
    end;

