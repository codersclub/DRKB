---
Title: Сохранить TListView как HTML страницу
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сохранить TListView как HTML страницу
=====================================

    function ListViewConfHTML(Listview:TListview; output:string; center: Boolean) : Boolean;
     var
       i,f: Integer;
       tfile: TextFile;
     begin
       try
         ForceDirectories(ExtractFilePath(output));
         AssignFile(tfile,output);
         ReWrite(tfile);
         WriteLn(tfile,'<html>');
         WriteLn(tfile,'<head>');
         WriteLn(tfile,'<title>HTML-Ansicht: '+listview.Name+'</title>');
         WriteLn(tfile,'</head>');
         WriteLn(tfile,'<table border="1" bordercolor="#000000">');
         WriteLn(tfile,'<tr>');
         for i := 0 to listview.Columns.Count - 1 do
         begin
           if center then
             WriteLn(tfile,'<td><b><center>'+listview.columns[i].caption+'</center></b></td>') else
             WriteLn(tfile,'<td><b>'+listview.columns[i].caption+'</b></td>');
         end;
         WriteLn(tfile,'</tr>');
         WriteLn(tfile,'<tr>');
         for i := 0 to listview.Items.Count-1 do
         begin
           WriteLn(tfile,'<td>'+listview.items.item[i].caption+'</td>');
           for f := 0 to listview.Columns.Count-2 do
           begin
             if listview.items.item[i].subitems[f]='' then Write(tfile,'<td>-</td>') else
               Write(tfile,'<td>'+listview.items.item[i].subitems[f]+'</td>');
           end;
           Write(tfile,'</tr>');
         end;
         WriteLn(tfile,'</table>');
         WriteLn(tfile,'</html>');
         CloseFile(tfile);
         Result := True;
       except
       Result := False;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       if ListViewConfHTML(form1.ListView1,'C:\text.html', true) then
         ShowMessage('OK/ Hat geklappt') else
           ShowMessage('Error occured/ Hat nicht geklappt');
     end;

