<h1>Указание языка помещенного в clipboard текста</h1>
<div class="date">01.01.2007</div>


<p>Столкнулся с проблемой вставки в Clipboard русского текста в Win2K, WinXP. Залез в DRKB.. Ну да, там вариант предложен довольно смешной (создать TRichEdit, вставить в него clipboard, весь текст пометить русским, и вернуть в clipboard)... Всё бы ничего, но если у меня программа без форм, да и без окон вообще, то TRichEdit не создаётся ('Control has no parent window') . Почитал хелп, посмотрел, что именно Вынь сует в буфер на разных языках, и нашёл простой и красивый способ. Имхо, ему там и место - в разделе "Буфер обмена".<br>
 <br>
Как вставить русский текст в буфер обмена Windows 2000, Windows XP<br>
 <br>
Для указания языка текста в clipboard используется специальный формат CF_LOCALE. Данные в этом формате - это LocaleID: word. При вставке текста в формате CF_TEXT, или CF_OEMTEXT, нужно просто добавить LocaleID в формате CF_LOCALE, после чего Windows сможет правильно преобразовать имеющийся текст в недостающие форматы (например в CF_UNICODETEXT), да и просто будет корректно вставлен в самом CF_TEXT.
<p></p>
<pre>
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
    //Set CF_TEXT &amp; CF_LOCALE
    CopyDataToClipboard(CF_TEXT, s);
    Locale := GetSystemDefaultLangID;  //Get it as you please. even hard-coded ;) $0419 = LANG_RUSSIAN (f.e.)
    CopyDataToClipboard(CF_LOCALE, Chr(Lo(Locale))+Chr(Hi(Locale)));
end;
</pre>
<div class="author">Автор: Mechanic</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

