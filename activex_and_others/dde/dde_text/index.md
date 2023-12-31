---
Title: DDE - передача текста
Date: 01.01.2007
---


DDE - передача текста
======================

::: {.date}
01.01.2007
:::

Вот я как работаю с Excel:

    type
      DDEClientConv1.SetLink('Excel', 'Sheet1');
    try
      DDEClientConv1.OpenLink;
      DDEClientItem1.DDEItem := 'R1C1';
      DDEClientConv1.PokeData(DDEClientItem1.DDEItem,
        StrPCopy(P, SomeString)));
    finally
      DDEClientConv1.CloseLink;
    end;

Как вы можете здесь видеть, свойство DDEItem определяется сервером. Если
ваш сервер является приложением Delphi, то DDEItem - имя DDEServerItem.
На вашем месте я бы не стал так долго заниматься отладкой DDE-программ.
Воспользуйтесь синхронизацией, позволяющей понять при отладке
правильность действий

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
