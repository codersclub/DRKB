---
Title: Как скопировать структуру таблицы?
Date: 01.01.2007
---


Как скопировать структуру таблицы?
==================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
