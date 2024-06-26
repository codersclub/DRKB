---
Title: Парсер подавляющего большинства нотаций XML
Author: Delirium, VideoDVD@hotmail.com
Date: 16.09.2003
Source: <https://forum.sources.ru>
---


Парсер подавляющего большинства нотаций XML
===========================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Парсер подавляющего большинства нотаций XML.
     
    Для задачи десериализации мне потребовался парсер.
    Основное преимущество - никак не связан с операционной системой
    (в отличие от TXMLDocument), ну и разумеется - простота :)
     
    Зависимости: SysUtils, StrUtils
    Автор:       Delirium, VideoDVD@hotmail.com, ICQ:118395746, Москва
    Copyright:   Delirium (Master BRAIN) 2003
    Дата:        16 сентября 2003 г.
    ***************************************************** }
     
    unit BNFXMLParser;
     
    interface
     
    uses SysUtils, StrUtils;
     
    type
      PXMLNode = ^TXMLNode;
     
      TXMLValues = (TextNode, XMLNode);
      TXMLNode = record
        Name: string;
        Attributes: array of record
          Name: string;
          Value: string;
        end;
        SubNodes: array of record
          RecType: TXMLValues;
          case TXMLValues of
            TextNode: (Text: PString);
            XMLNode: (XML: PXMLNode);
        end;
        Parent: PXMLNode;
      end;
     
    function BNFXMLTree(var Value: string): PXMLNode;
     
    implementation
     
    function fnTEG(var Node: PXMLNode; var Value: string): boolean; forward;
    function fnVAL(var Node: PXMLNode; var Value: string): boolean; forward;
    function fnATT(var Node: PXMLNode; var Value: string): boolean; forward;
     
    function fnXML(var Node: PXMLNode; var Value: string): boolean;
    var
      i: integer;
    begin
      if (Pos('<', Value) > 0)
        and (Pos('>', Value) > Pos('<', Value))
        and (Pos('<', Value) <> Pos('</', Value)) then
      begin
        // Оганизую узел
        if Node = nil then
        begin
          New(Node);
          Node.Parent := nil;
        end
        else
        begin
          i := length(Node.SubNodes);
          Setlength(Node.SubNodes, i + 1);
          New(Node.SubNodes[i].XML);
          Node.SubNodes[i].RecType := XMLNode;
          Node.SubNodes[i].XML.Parent := Node;
          Node := Node.SubNodes[i].XML;
        end;
        Result := fnTEG(Node, Value);
      end // '<'
      else
        Result := True;
    end;
     
    function fnTEG(var Node: PXMLNode; var Value: string): boolean;
    var
      i, i1, i2, i3: integer;
      S: string;
    begin
      Result := False;
      i1 := Pos('<', Value);
      if i1 > 0 then
      begin
        i2 := PosEx('/>', Value, i1);
        i3 := PosEx('>', Value, i1);
        if (i2 > 0) and (i2 < i3) then
        begin // <abc/>
          // Value
          S := Copy(Value, i1 + 1, (i2 - i1) - 1);
          Delete(Value, i1, (i2 - i1) + 2);
          // TEXT, этот текст пренадлежит предку
          if Node.Parent <> nil then
          begin // Добавляюсь к предку
            i := length(Node.Parent.SubNodes);
            Setlength(Node.Parent.SubNodes, i + 1);
            New(Node.Parent.SubNodes[i].Text);
            Node.Parent.SubNodes[i].RecType := TextNode;
            Node.Parent.SubNodes[i].Text^ := Copy(Value, 1, Pos('<', Value) - 1);
          end;
          Delete(Value, 1, Pos('<', Value) - 1);
          //
          if fnVAL(Node, S) then
          begin // Вложенных тегов не бывает
            Node := Node.Parent;
            Result := fnXML(Node, Value);
          end;
        end
        else
        begin // <abc>...</abc>
          // Value
          S := Copy(Value, i1 + 1, (i3 - i1) - 1);
          Delete(Value, i1, (i3 - i1) + 1);
          // TEXT
          i := length(Node.SubNodes);
          Setlength(Node.SubNodes, i + 1);
          New(Node.SubNodes[i].Text);
          Node.SubNodes[i].RecType := TextNode;
          Node.SubNodes[i].Text^ := Copy(Value, 1, Pos('<', Value) - 1);
          Delete(Value, 1, Pos('<', Value) - 1);
          //
          if fnVAL(Node, S) then
          begin // Val
            // Проверяю закрытие тега, удаляю хвост и передаю управление предку
            if Pos('</' + AnsiLowerCase(Node.Name) + '>', AnsiLowerCase(Value)) = 1
              then
            begin
              Delete(Value, 1, Length('</' + Node.Name + '>'));
              // TEXT принадлежащий предку
              if Node.Parent <> nil then
              begin // Добавляюсь к предку
                i := length(Node.Parent.SubNodes);
                Setlength(Node.Parent.SubNodes, i + 1);
                New(Node.Parent.SubNodes[i].Text);
                Node.Parent.SubNodes[i].RecType := TextNode;
                Node.Parent.SubNodes[i].Text^ := Copy(Value, 1, Pos('<', Value) -
                  1);
              end;
              Delete(Value, 1, Pos('<', Value) - 1);
              Node := Node.Parent;
              Result := fnXML(Node, Value);
            end
            else
            begin
              // Обрабатываю вложенные теги, на выходе мой узел
              if fnXML(Node, Value) then
              begin
                // закрываю его
                if Pos('</' + AnsiLowerCase(Node.Name) + '>', AnsiLowerCase(Value))
                  = 1 then
                begin
                  Delete(Value, 1, Length('</' + Node.Name + '>'));
                  // TEXT принадлежащий предку
                  if Node.Parent <> nil then
                  begin // Добавляюсь к предку
                    i := length(Node.Parent.SubNodes);
                    Setlength(Node.Parent.SubNodes, i + 1);
                    New(Node.Parent.SubNodes[i].Text);
                    Node.Parent.SubNodes[i].RecType := TextNode;
                    Node.Parent.SubNodes[i].Text^ := Copy(Value, 1, Pos('<', Value)
                      - 1);
                  end;
                  Delete(Value, 1, Pos('<', Value) - 1);
                end;
                // Остальной XML - предку
                if Node.Parent <> nil then
                  Node := Node.Parent;
                Result := fnXML(Node, Value);
              end;
            end;
          end; // Val
        end; // <abc>...</abc>
      end; // i1
    end;
     
    function fnVAL(var Node: PXMLNode; var Value: string): boolean;
    begin
      Value := AnsiReplaceStr(Value, '''', '"');
      if (Pos(' ', Value) > 0)
        and (Pos('="', Value) > Pos(' ', Value)) then
      begin
        Node.Name := Trim(Copy(Value, 1, Pos(' ', Value) - 1)); // Название тега Name
        Delete(Value, 1, Pos(' ', Value));
        Result := fnATT(Node, Value);
      end // ' ' и ('="'
      else
      begin
        // Название тега Name
        Value := Trim(Value);
        if Pos(' ', Value) > 0 then
          Node.Name := Copy(Value, 1, Pos(' ', Value) - 1)
        else
          Node.Name := Value;
        Value := '';
        Result := True;
      end;
    end;
     
    function fnATT(var Node: PXMLNode; var Value: string): boolean;
    begin
      Result := True;
      Value := Trim(Value);
      if Pos('="', Value) > 0 then
      begin
        Result := False;
        SetLength(Node.Attributes, Length(Node.Attributes) + 1);
        // Название атрибута
        Node.Attributes[Length(Node.Attributes) - 1].Name := Trim(Copy(Value, 1,
          Pos('="', Value) - 1));
        Delete(Value, 1, Pos('="', Value) + 1);
        if Pos('"', Value) > 0 then
        begin
          // Значение атрибута
          Node.Attributes[Length(Node.Attributes) - 1].Value := Copy(Value, 1,
            Pos('"', Value) - 1);
          Delete(Value, 1, Pos('"', Value));
          if Length(Value) > 0 then
            Result := fnATT(Node, Value)
          else
            Result := True;
        end;
      end;
    end;
     
    function BNFXMLTree(var Value: string): PXMLNode;
    begin
      Result := nil;
      fnXML(Result, Value);
    end;
     
    end.




Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      S: string;
      Node: PXMLNode;
      i: integer;
    begin
      S := '<A> aaa1 ' + #13 +
        ' aaa2 aaa3 ' + #13 +
        ' <B>bbb ' + #13 +
        ' <C>ccc</C> ' + #13 +
        ' </B> ' + #13 +
        ' <D>ddd ' + #13 +
        ' <E eee="EEE"/> ' + #13 +
        ' </D> ' + #13 +
        '</A> ';
      Node := BNFXMLTree(S);
      for i := 0 to Length(Node.SubNodes) - 1 do
        case Node.SubNodes[i].RecType of
          TextNode: ShowMessage('Text = ' + Node.SubNodes[i].Text^);
          XMLNode: ShowMessage('XML Node name = ' + Node.SubNodes[i].XML.Name);
        end;
    end;

Сайт: http://delphibase.endimus.com

