---
Title: Как скопировать структуру таблицы?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как скопировать структуру таблицы?
==================================

Как известно, таблицы Paradox состоят из файла таблицы и некоторых соответствующих индексных файлов.

Есть много способов их скопировать:

1. Использование TBatchMover (в DataAccess Pallete) с режимом: BatCopy.  
   Но вы не можете скопировать таблицы, соответствующие индексным файлам, просто TBatchMove
   копирует структуру и данные.
2. Использование FileCopy.  
   Но вы не можете автоматически копировать таблицы, соответствующие индексным файлам,
   вы должны определить каждый файл
   ... и многое другое
     
Простое решение:

Поместите в форму две таблицы TTable, назовите их tbSource и tbTarget.
Затем поместите эту процедуру в область реализации.


    { 
      As we know, Paradox Tables consist in a table file and some corresponding index files 
      there are many way to copy them: 
        1. Using TBatchMover (at DataAccess Pallete) with Mode : BatCopy 
           But you can't copy the tables corresponding index files, TBatchMove just 
           copies the structure and data. 
        2. Using FileCopy 
           But you can't copy the tables corresponding index files automatically, 
           you should define each files 
        .. and many more 
     
      The Simple way is: 
     
      Put two TTables on your form, name it as tbSource and tbTarget. 
      Then, put this procedure under implementation area 
    } 
     
    type 
      TForm1 = class(TForm) 
        tbSource: TTable; 
        tbTarget: TTable; 
        // ... 
      end; 
     
    implementation 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      tbSource.TableName := 'Source.DB';  // The name of your tables which you want to copy from 
      tbTarget.TableName := 'Target.DB';  // The name of your tables which you will to copy to 
                                          // You Can  set the tbSource.DataBaseName to an existing path/Alias 
                                          //    where you store your DB 
                                          // You Can  set the tbTarget.DataBaseName to an existing path/Alias 
                                          //    where you want to store the duplicate DB 
      tbSource.StoreDefs := True; 
      tbTarget.StoreDefs := True; 
      tbSource.FieldDefs.Update; 
      tbSource.IndexDefs.Update; 
      tbTarget.FieldDefs := tbSource.FieldDefs; 
      tbTarget.IndexDefs := tbSource.IndexDefs; 
      tbTarget.CreateTable; 
      //Actually you can set these code up to only 5 lines :) 
    end; 
     
     
    End. 

