---
Title: Копируем русский текст в буфер обмена в Windows 2000
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Копируем русский текст в буфер обмена в Windows 2000
====================================================

У меня Windows NT/2000. Когда копирую текст на русском языке, скажем, из
TMemo в Ворд 97/2000, то получаю в результате каракули. Эти каракули
исправляются, если перед копированием насильно переключить клавиатуру
пользователя на русский язык. Но если у него нет этой клавиатуры, или
если лучше не переключать ее, то как можно сообщить системе, что мы
будем копировать РУССКИЙ текст. На форме создается невидимый TRichEdit
(я обозвал его TRE в коде). Далее текст копируется в клипборд как
обычно, после чего вызывается следующая процедура

    procedure TMainForm.ConvertClipboard;
    begin
     TRE.SelectAll;
     TRE.ClearSelection;
     TRE.Lines.Add(Clipboard.AsText);
     TRE.SelectAll;
     
     TRE.Font.Name := 'Times New Roman'; //тут нужный шрифт
     TRE.Font.Size := 12; // тут нужный размер
     // или просто берите TRE.Font := MainMemo.Font;
     
     TRE.SelAttributes.Charset := RUSSIAN_CHARSET;
     TRE.CopyToClipboard;
    end

