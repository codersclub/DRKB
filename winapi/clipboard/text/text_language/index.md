---
Title: Указание языка помещенного в clipboard текста
Author: Mechanic
Source: <https://forum.sources.ru>
Date: 01.01.2007
---


Указание языка помещенного в clipboard текста
=============================================

Столкнулся с проблемой вставки в Clipboard русского текста в Win2K,
WinXP. Залез в DRKB.. Ну да, там вариант предложен довольно смешной
(создать TRichEdit, вставить в него clipboard, весь текст пометить
русским, и вернуть в clipboard)...

Всё бы ничего, но если у меня
программа без форм, да и без окон вообще, то TRichEdit не создаётся
(\'Control has no parent window\').

Почитал хелп, посмотрел, что именно
Вынь сует в буфер на разных языках, и нашёл простой и красивый способ.
Имхо, ему там и место - в разделе "Буфер обмена".

**Как вставить русский текст в буфер обмена Windows 2000, Windows XP**

Для указания языка текста в clipboard используется специальный формат
CF\_LOCALE. Данные в этом формате - это LocaleID: word. При вставке
текста в формате CF\_TEXT, или CF\_OEMTEXT, нужно просто добавить
LocaleID в формате CF\_LOCALE, после чего Windows сможет правильно
преобразовать имеющийся текст в недостающие форматы (например в
CF\_UNICODETEXT), да и просто будет корректно вставлен в самом CF\_TEXT.

    procedure CopyDataToClipboard(fmt: word; s: string);
    var
        hg: THandle;
        P: PChar;
    begin
        hg:=GlobalAlloc(GMEM_DDESHARE or GMEM_MOVEABLE, Length(S)+1);
        P:=GlobalLock(hg);
        StrPCopy(P, s);
        GlobalUnlock(hg);
        Clipboard.Open;
        SetClipboardData(fmt, hg); // fmt = CF_UNICODETEXT | CF_OEMTEXT | CF_TEXT | CF_LOCALE
        Clipboard.Close;
        GlobalFree(hg);
    end;
     
    procedure CopyStringToClipboard(const s: string);
    var Locale: word;
    begin
        //Set CF_TEXT & CF_LOCALE
        CopyDataToClipboard(CF_TEXT, s);
        Locale := GetSystemDefaultLangID;  //Get it as you please. even hard-coded ;)
                                           //$0419 = LANG_RUSSIAN (f.e.)
        CopyDataToClipboard(CF_LOCALE, Chr(Lo(Locale))+Chr(Hi(Locale)));
    end;

