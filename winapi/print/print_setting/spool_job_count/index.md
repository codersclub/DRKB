---
Title: Определение количества заданий в спулере печати
Author: Song
Date: 01.01.2007
---

Определение количества заданий в спулере печати
===============================================

::: {.date}
01.01.2007
:::

Spooler печати Windows посылает WM\_SPOOLERSTATUS каждый раз при
добавлении и удалении заданий в очереди печати. В следующем примере
показано как перехватить это сообщение:

    type
    TForm1 = class(TForm)
        Label1: TLabel;
    private
        { Private declarations }
        procedure WM_SpoolerStatus(var Msg : TWMSPOOLERSTATUS); message WM_SPOOLERSTATUS;
    public
        { Public declarations }
    end;
     
    var
    Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WM_SpoolerStatus(var Msg : TWMSPOOLERSTATUS);
    begin
        Lable1.Caption := IntToStr(msg.JobsLeft) + ' Jobs currenly in spooler';
        msg.Result := 0;
    end;

Автор: Song

Взято из <https://forum.sources.ru>
