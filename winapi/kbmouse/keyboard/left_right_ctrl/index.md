---
Title: Как отличить нажат правый или левый CTRL?
Date: 01.01.2007
---


Как отличить нажат правый или левый CTRL?
=========================================

::: {.date}
01.01.2007
:::

Для того, чтобы отличить нажат левый или правый Ctrl, нужно перехватить
событие WM\_KEYDOWN. В зависимости от состояния 24-ого бита параметра
LParam нажата правая или левая клавиша.

    public
      procedure WMKEYDOWN(var msg: TMessage); message WM_KEYDOWN;
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WMKEYDOWN(var msg: TMessage);
    begin
      if (msg.LParam and (255 shl 16)) shr 16 <> 29 then
        Exit;
      if msg.LParam and (1 shl 24) > 0 then
        Form1.Caption := 'Right'
      else
        Form1.Caption := 'Left';
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
