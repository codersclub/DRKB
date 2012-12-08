---
Title: Удаление HTML элементов из текста
Date: 01.01.2007
---


Удаление HTML элементов из текста
=================================

::: {.date}
01.01.2007
:::

Как-то раз пришлось решить задачу удаления из файла элементов HTML
таких, как, например, ненужные ссылки, и в то эе время преобразования
возврата каретки в HTML параграфы, знаков табуляции в пробелы и т.д. В
результате соответственно должен был получиться новый HTML документ.

Следующие две процедуры показывают, как это можно сделать:

    procedure TMainForm.LoadFileIntoList(TextFileName:String; AWebPage:TStringList; WithFilter:Boolean); 
    var CurrentFile : TStringList; 
    begin 
       CurrentFile := TStringList.Create; 
       CurrentFile.LoadFromFile(TextFileName); 
       if WithFilter then 
          FilterHTML(CurrentFile,AWebPage) 
       else 
          with AWebPage do AddStrings(CurrentFile); 
       CurrentFile.Free; 
    end; 
     
    procedure TMainForm.FilterHTML(FilterInput, AWebPage:TStringList); 
    var 
       i,j : LongInt; 
       S   : String; 
    begin 
       FilterMemo.Lines.Clear; 
       FilterMemo.Lines := FilterInput; 
     
       with AWebPage do 
       begin 
          FilterMemo.SelectAll; 
          j := FilterMemo.SelLength; 
     
          if j > 0 then 
          begin 
             i := 0; 
             repeat 
                if FilterMemo.Lines.GetText[i] = Char(VK_RETURN)      // ищем cr 
                then S := S+'
    ' 
                else if FilterMemo.Lines.GetText[i] = '<' 
                     then repeat 
                             inc(i); 
                          until FilterMemo.Lines.GetText[i] = '>' 
                     else if FilterMemo.Lines.GetText[i] = Char(VK_TAB)   // ищем tab 
                          then S := S+'    ' 
                          else S := S+ FilterMemo.Lines.GetText[i];     // добавляем текст 
                inc(i); 
             until i = j+1; 
             Add(S);     // добавляем строку в WebPage 
          end else Add('No data entered into field.');   // no data in text file 
       end; 
    end; 

Применение функции:

Всё, что нужно сделать - это вызвать :

LoadFileIntoList(\"filename.txt\",Webpage, True);

Где filename - это имя файла, который вы хотите обработать.

\"WebPage\" - это TStringList

последний параметр в функции указывает, применять или нет HTML-фильтр.

PS: В этом примере объект TMemo (который вызывается из \"FilterMemo\")
лежит на форме и поэтому не видим.

    WebPage := TStringList.Create; 
       try 
          Screen.Cursor := crHourGlass; 
          AddHeader(WebPage); 
          with WebPage do 
          begin 
             Add('Personal Details');         
             LoadFileIntoList("filename.txt",Webpage, True); 
          end; 
          AddFooter(WebPage); 
       finally 
          WebPage.SaveToFile(HTMLFileName); 
          WebPage.Free; 
          Screen.Cursor := crDefault; 
       end; 

Взято из <https://forum.sources.ru>
