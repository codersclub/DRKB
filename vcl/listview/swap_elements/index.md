---
Title: Обмен значениями элементов TListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Обмен значениями элементов TListView
====================================

Today I want to describe how you may exchange some items in standard
TListView. For example, you have 5 items and want to swap
positions for first and third items.

Problem that standard TListView component haven\'t
such method and you must realize it yourself.

We remember that the standard way from old Pascal times (for numbers)
is:

     procedure Swap(X, Y: Integer);
     var
       s: Integer;
     begin
       s := X;
       X := Y;
       Y := X
     end;

Something similar we can do with TListItem too.

But just to save all strings (caption+sub items) somewhere is not enough
because TListItem class have a lot of other information (image indexes,
pointer as Data, etc)

So correct way is to use Assign method:

     procedure ExchangeItems(lv: TListView; const i, j: Integer);
     var
       tempLI: TListItem;
     begin
       lv.Items.BeginUpdate;
       try
         tempLI := TListItem.Create(lv.Items);
         tempLI.Assign(lv.Items.Item[i]);
         lv.Items.Item[i].Assign(lv.Items.Item[j]);
         lv.Items.Item[j].Assign(tempLI);
         tempLI.Free;
       finally
         lv.Items.EndUpdate
       end;
     end;

So structure is a same as in our sample for Integer. All what we added
are BeginUpdate and EndUpdate (just allow to reduce a flickering).

So if you want to exchange items in any ListView, just call this
procedure...

