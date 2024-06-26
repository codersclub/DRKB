---
Title: Парсер XML
Author: Delirium, VideoDVD@hotmail.com
Date: 22.10.2003
---


Парсер XML
==========

Данный прасер не такой универсальный, как [предыдущий](../xml_parser/),
но зато - почти в 1000 раз эффективнее!

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Разбор XML
     
    Данный прасер не такой универсальный, как предыдущий,
    но зато - почти в 1000 раз эффективнее!
     
    Зависимости: Windows, Forms, SysUtils, StrUtils
    Автор:       Delirium, VideoDVD@hotmail.com, ICQ:118395746, Москва
    Copyright:   Delirium (Master BRAIN) 2003
    Дата:        22 октября 2003 г.
    ********************************************** }
     
    unit BNFXMLParser2;
     
    interface
     
    uses Windows, Forms, SysUtils, StrUtils;
     
    type
     PXMLNode=^TXMLNode;
     PXMLTree=^TXMLTree;
     TXMLAttr=record
              NameIndex, NameSize:integer;
              TextIndex, TextSize:integer;
              end;
     TXMLNode=record
              NameIndex, NameSize:integer;
              Attributes:array of TXMLAttr;
              TextIndex, TextSize:integer;
              SubNodes:array of PXMLNode;
              Parent:PXMLNode;
              Data:PString;
              end;
     TXMLTree=record
              Data:PString;
              TextSize:integer;
              NodesCount:integer;
              Nodes:array of PXMLNode;
              end;
     
    function BNFXMLTree(Value:String):PXMLTree;
    function GetXMLNodeName(Node:PXMLNode):String;
    function GetXMLNodeText(Node:PXMLNode):String;
    function GetXMLNodeAttr(AttrName:String; Node:PXMLNode):String;
     
    implementation
     
     
    function BNFXMLTree(Value:String):PXMLTree;
    var LPos, k, State, CurAttr:integer;
        i:integer;
        CurNode:PXMLNode;
    begin
    New(Result);
    Result^.TextSize:=Pos('<', Value)-1;
    New(Result^.Data);
    Result^.Data^:=Value;
    k:=0;
    State:=0;
    CurNode:=nil;
    CurAttr:=-1;
    for LPos:=Result.TextSize+1 to Length(Value) do
     case State of
      0:case Value[LPos] of
         '<':begin
             i:=length(Result.Nodes);
             Setlength(Result.Nodes, i+1);
             New(Result.Nodes[i]); Inc(k);
             if k mod 10 = 0 then
              begin
              Application.ProcessMessages;
              if k mod 100 = 0 then SleepEx(1, True);
              end;
             CurNode:=Result.Nodes[i];
             CurNode^.NameIndex:=0;
             CurNode^.NameSize:=0;
             CurNode^.TextIndex:=0;
             CurNode^.Parent:=nil;
             CurNode^.Data:=Result^.Data;
             State:=1;
             end;
         end;
      1:case Value[LPos] of
         ' ':;
         '>':State:=9;
         '/':State:=10;
         else begin
             CurNode^.NameIndex:=LPos;
             CurNode^.NameSize:=1;
             State:=2;
             end;
         end;
      2:case Value[LPos] of
         ' ':State:=3;
         '>':State:=9;
         '/':State:=10;
         else Inc(CurNode^.NameSize);
         end;
      3:case Value[LPos] of
         ' ':;
         '>':State:=9;
         '/':State:=10;
        else begin
             i:=length(CurNode^.Attributes);
             Setlength(CurNode^.Attributes, i+1);
             CurNode^.Attributes[i].NameIndex:=LPos;
             CurNode^.Attributes[i].NameSize:=1;
             CurAttr:=i;
             State:=4;
             end;
         end;
      4:case Value[LPos] of
         '=':State:=5;
         else Inc(CurNode^.Attributes[CurAttr].NameSize);
         end;
      5:case Value[LPos] of
         '''':State:=6;
         '"':State:=7;
         end;
      6:case Value[LPos] of
         '''':begin
             CurNode^.Attributes[CurAttr].TextIndex:=LPos;
             CurNode^.Attributes[CurAttr].TextSize:=0;
             State:=8;
             end;
         else begin
             CurNode^.Attributes[CurAttr].TextIndex:=LPos;
             CurNode^.Attributes[CurAttr].TextSize:=1;
             State:=61;
             end;
         end;
      7:case Value[LPos] of
         '"':begin
             CurNode^.Attributes[CurAttr].TextIndex:=LPos;
             CurNode^.Attributes[CurAttr].TextSize:=0;
             State:=8;
             end;
        else begin
             CurNode^.Attributes[CurAttr].TextIndex:=LPos;
             CurNode^.Attributes[CurAttr].TextSize:=1;
             State:=71;
             end;
         end;
     61:case Value[LPos] of
         '''':State:=8;
         else Inc(CurNode^.Attributes[CurAttr].TextSize);
         end;
     71:case Value[LPos] of
         '"':State:=8;
         else Inc(CurNode^.Attributes[CurAttr].TextSize);
         end;
      8:case Value[LPos] of
         ' ':State:=3;
         '>':State:=9;
         '/':State:=10;
         end;
      9:case Value[LPos] of
         '<':State:=12;
         else begin
             CurNode^.TextIndex:=LPos;
             CurNode^.TextSize:=1;
             State:=11;
             end;
         end;
     10:case Value[LPos] of
         '>':begin
             CurNode:=CurNode^.Parent;
             if CurNode=nil
              then State:=0
              else State:=9;
             end;
         end;
     11:case Value[LPos] of
         '<':State:=12;
         else Inc(CurNode^.TextSize);
         end;
     12:case Value[LPos] of
         '/':State:=10;
         else begin
             i:=length(CurNode^.SubNodes);
             Setlength(CurNode^.SubNodes, i+1);
             New(CurNode^.SubNodes[i]); Inc(k);
             if k mod 10 = 0 then
              begin
              Application.ProcessMessages;
              if k mod 100 = 0 then SleepEx(1, True);
              end;
             CurNode^.SubNodes[i]^.Parent:=CurNode;
             CurNode^.SubNodes[i]^.Data:=Result^.Data;
             CurNode^.SubNodes[i].NameIndex:=LPos;
             CurNode^.SubNodes[i].NameSize:=1;
             CurNode^.SubNodes[i].TextIndex:=0;
             CurNode:=CurNode^.SubNodes[i];
             State:=2;
             end;
         end;
      end;
    Result^.NodesCount:=k;
    end;
     
    function GetXMLNodeName(Node:PXMLNode):String;
    begin
     Result:=Copy(Node^.Data^, Node^.NameIndex, Node^.NameSize);
    end;
     
    function GetXMLNodeText(Node:PXMLNode):String;
    begin
     Result:=Copy(Node^.Data^, Node^.TextIndex, Node^.TextSize);
    end;
     
    function GetXMLNodeAttr(AttrName:String; Node:PXMLNode):String;
    var i:integer;
    begin
     Result:='';
     if Length(Node^.Attributes)=0 then exit;
     i:=0;
     while (i<Length(Node^.Attributes))
       and (AnsiLowerCase(AttrName)<>AnsiLowerCase(Trim(Copy(Node^.Data^, Node^.Attributes[i].NameIndex, Node^.Attributes[i].NameSize))))
       do Inc(i);
     Result:=Copy(Node^.Data^, Node^.Attributes[i].TextIndex, Node^.Attributes[i].TextSize);
     end;
     
    end.
