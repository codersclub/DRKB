---
Title: Как узнать версию компиллятора?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как узнать версию компиллятора?
===============================

Иногда надо выполнить разный код в зависимости от версии Дельфи,
особенно актуально это при разработки компонентов и модулей, которые
используются в разных приложениях.

В Дельфи предопределены специальные константы компиляции для этого:

Ver80 - Дельфи 1  
Ver90 - Дельфи 2  
Ver93 - С Buider 1  
Ver100 - Дельфи 3  
Ver110 - С Buider 3  
Ver120 - Дельфи 4  
Ver125 - С Buider 4  
Ver130 - Дельфи 5  
Ver140 - Дельфи 6  
Ver150 - Дельфи 7

Пример использования:

    procedure TForm1.Button2Click(Sender: TObject);

    const Version=
    {$Ifdef Ver80}'Дельфи 1';{$EndIf}  
    {$Ifdef Ver90}'Дельфи 2';{$EndIf} 
    {$Ifdef Ver100}'Дельфи 3';{$EndIf}
    {$Ifdef Ver120}'Дельфи 4';{$EndIf} 
    {$Ifdef Ver130}'Дельфи 5 ';{$EndIf}
    {$Ifdef Ver140}'Дельфи 6';{$EndIf}
    {$Ifdef Ver150}'Дельфи 7';{$EndIf} 
    begin
      ShowMessage('Для компиляции этой программы был использован '
                  + Version);
    end;

