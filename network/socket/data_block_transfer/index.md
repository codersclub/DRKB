---
Title: Процедуры передачи и приема блоков данных, с учетом фрагментации и склейки пакетов
author: Camsonov Aleksandr, s002156@mail.ru
Date: 02.10.2002
---


Процедуры передачи и приема блоков данных, с учетом фрагментации и склейки пакетов
==================================================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Процедуры передачи и приема блоков данных, с учетом фрагментации и склейки пакетов. Построено на TServerSocket,TClientSocket ..SendText
     
    Отправка:
    пользователь создает строку 'Строка пользователя'
    дорабатываем строку до '<19>Строка пользователя'
    отправляем
    Принимаем:
    1 принятый кусок строки добавляем в конец буферной строки bstr;
    2 вызываем прочедуру которая
    a) удаляет (если есть ;|) часть bstr до '<'; //(это на случай ошибки, правда такого явления я незамечал здесь но на всякий случай предусмотрел так спокойнее)
    b) копирует участок '<число>' и достает из него число;
    c) если длинна полученного буфера минус длинна участка '<число>' меньше bstr то ниче не делаем и выходим из проседуры.
    иначе отрезаем от bstr участок '<число>' копируем кусок bstr длинной 'число' символов в ostr, удаляем этотже кусок из bstr.
    d) передает ostr кому оно надо ибо ostr это то что послал пользоатель отдельным куском.
     
    все. Пом очень просто алгоритм работает без отказно и ниче тут непопишеш.
     
    Зависимости: ScktComp
    Автор:       Camsonov Aleksandr, s002156@mail.ru, Tver
    Copyright:   SELMAP_Group_Programmers/s002156Shurik
    Дата:        2 октября 2002 г.
    ********************************************** }
     
    var
      Buffer:String = '';
    {$R *.dfm}
     
    function GetUserStringFromBuffer(var UserString:String):Boolean;
    var
      i:Integer;
      bf:String;
    begin
      Result:=False;
      if Length(Buffer)>0 then
      repeat 
        if Length(Buffer)>0 then 
          if Buffer[1]<>'<'then Delete(Buffer,1,1);
      until (Buffer[1]='<')or(Length(Buffer)<=1);
      if Length(Buffer)<3 then exit;
      i:=1; bf:='';
      repeat
        if Length(Buffer)>=i then
        begin
          inc(i);
          if Buffer[i]<>'>'then bf:=bf+Buffer[i];
        end;
      until(Buffer[i]='>')or(Length(Buffer)<=1);
      if StrToInt(bf)+i>Length(Buffer) then exit
      else
      begin
        Delete(Buffer,1,i);
        UserString:=Copy(Buffer,1,StrToInt(bf));
        Result:=True;
        Delete(Buffer,1,StrToInt(bf));
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      S:String;
    begin
      s:='<'+inttostr(length(Edit1.Text))+'>'+Edit1.Text;
      ClientSocket1.Socket.SendText(S);
         //В качестве ТЕСТА отправляю еще несколько копий этой строки
         //для того чтобы все они ушли в одном пакете. (слипание)
      ClientSocket1.Socket.SendText(S);
      ClientSocket1.Socket.SendText(S);
      ClientSocket1.Socket.SendText(S);
    end;
     
    procedure TForm1.ServerSocket1ClientRead(Sender: TObject;
      Socket: TCustomWinSocket);
    var
      GetResult:Boolean;
      UserStr:String;
    begin
      Buffer:=Buffer+Socket.ReceiveText;
      // в буфер приходят слипшиеся строки
      //перезапуск функции вытаскивания кусков до False (пока куски незакончатся)
      //если отправленный текст получен неполностью тоже возвращается False
      repeat
        GetResult:=GetUserStringFromBuffer(UserStr);
        if GetResult then ShowMessage(UserStr); //передается отосланная строка
                                                //ЦЕЛАЯ И БЕЗ МУСОРА!
      until not GetResult;
    end;
