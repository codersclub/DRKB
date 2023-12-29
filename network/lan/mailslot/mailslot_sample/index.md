---
Title: Пример работы с MailSlot
Author: Baa
Date: 01.01.2007
---


Пример работы с MailSlot
========================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
     hSlot1      : THandle;
     lpszSlotName: LPSTR;
    begin
     lpszSlotName := '\\\\.\\mailslot\\sample_mailslot';
     hslot1 := CreateMailslot (lpszSlotName,
                               0,
                               MAILSLOT_WAIT_FOREVER,
                               nil);
     //тут поидее должна быть обработка ошибки, если не удалось создать 
     //Далее работаем с ним, как с файлом т.е. WriteFile и т.д.
     // CloseHandle(hSlot1); //а кады закрываем за собой дескриптор, 
     //то память чистится т.е. все, что мы туда поназаписали удаляется
    end;

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>

--------------------------------------

WinAPI-\>Windows-\>Процессы...-\>Пример работы с MailSlot

Тут Baa немного ошибся. Он написал открытие мэйлслота в C++ стиле:

lpszSlotName := \'\\\\\\\\.\\\\mailslot\\\\sample\_mailslot\';

а надо так:

lpszSlotName := \'\\\\.\\mailslot\\sample\_mailslot\';

т.е. вместо \\\\ надо просто \

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
