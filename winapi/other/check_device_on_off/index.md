---
Title: Определение подключения / отключения нового устройства
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Определение подключения / отключения нового устройства
======================================================

::: {.date}
01.01.2007
:::

Маленький коментарий:
При открытии сидирома срабатывает DBT\_DEVICEREMOVECOMPLETE, при
закрытии DBT\_DEVICEARRIVAL
При подключении сетевого диска также приходит DBT\_DEVICEARRIVAL а при
отключении DBT\_DEVICEREMOVECOMPLETE
При подключении или отключении флэшки срабатывает
DBT\_DEVNODES\_CHANGED...

 

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, MMSystem;
     
    type
      TForm1 = class(TForm)
      public
        procedure CD(var Msg: TMessage); message WM_DEVICECHANGE;
      end;
     
    const
      DBT_DEVICEARRIVAL = $8000;
      DBT_DEVICEREMOVECOMPLETE = $8004;
      DBT_DEVNODES_CHANGED = $7;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    { TForm1 }
     
    procedure TForm1.CD(var Msg: TMessage);
    begin
      case Msg.WParam of
        DBT_DEVNODES_CHANGED: Caption := 'Flash change';
        DBT_DEVICEARRIVAL: Caption := 'CD close with new disk';
        DBT_DEVICEREMOVECOMPLETE: Caption := 'CD open';
        //DBT_DEVICEARRIVAL: Caption := 'New network disk maped';
        //DBT_DEVICEREMOVECOMPLETE: Caption := 'Network disk unmaped';
      else
        Caption := 'Unknown';
      end;
    end;
     
    end.

Автор: Александр (Rouse\_) Багель

Взято из <https://forum.sources.ru>
