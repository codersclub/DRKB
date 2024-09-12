---
Title: Как определить, сколько памяти выделено в Delphi для программы?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как определить, сколько памяти выделено в Delphi для программы?
===============================================================

Для этого можно воспользоваться функцией GetHeapStatus:

    lwMem.Items.Clear;
    s := LastStatsList[cbCompare.ItemIndex];
    LastStatsList[0] := GetHeapStatus;
    LastStats := LastStatsList[PointId];
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'TotalAddrSpace';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.TotalAddrSpace])));
    tmp := s.TotalAddrSpace - LastStats.TotalAddrSpace;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'TotalUncommitted';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.TotalUncommitted])));
    tmp := s.TotalUncommitted - LastStats.TotalUncommitted;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'TotalCommitted';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.TotalCommitted])));
    tmp := s.TotalCommitted - LastStats.TotalCommitted;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'TotalAllocated';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.TotalAllocated])));
    tmp := s.TotalAllocated - LastStats.TotalAllocated;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'TotalFree';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.TotalFree])));
    tmp := s.TotalFree - LastStats.TotalFree;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'FreeSmall';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.FreeSmall])));
    tmp := s.FreeSmall - LastStats.FreeSmall;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'FreeBig';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.FreeBig])));
    tmp := s.FreeBig - LastStats.FreeBig;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'Unused';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.Unused])));
    tmp := s.Unused - LastStats.Unused;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'Overhead';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.Overhead])));
    tmp := s.Overhead - LastStats.Overhead;
    ListItem.SubItems.Add(DeltaToStr(tmp));
     
    ListItem := lwMem.Items.Add;
    ListItem.Caption := 'HeapErrorCode';
    ListItem.SubItems.Add(Numb2USA(Format(strFormat,[s.HeapErrorCode])));

