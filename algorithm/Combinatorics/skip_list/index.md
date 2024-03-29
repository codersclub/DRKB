---
Title: Example of Skip List source code
Date: 01.01.2007
Source: <https://algolist.manual.ru>
---


Example of Skip List source code
================================

    {* 
     
    Example of Skip List source code for Pascal:
     
    Skip Lists are a probabilistic alternative to balanced trees, as
    described in the June 1990 issue of CACM and were invented by 
    William Pugh in 1987. 
     
    This file contains source code to implement a dictionary using 
    skip lists and a test driver to test the routines.
     
    A couple of comments about this implementation:
      The routine randomLevel has been hard-coded to generate random
      levels using p=0.25. It can be easily changed.
     
      The insertion routine has been implemented so as to use the
      dirty hack described in the CACM paper: if a random level is
      generated that is more than the current maximum level, the
      current maximum level plus one is used instead.
     
    The code, as presented, allows duplicate entries which act in a FIFO
    manner. To disallow duplicates, the insert procedure needs to be modified
    as indicated in the insert procedure.
     
    The library includes an adaptation of the Unix C random number generator,
    since the standard Pascal random number generator is unsuitable. 
     
    An attempt has been made to make sure that no integer overflow occurs
    in the random number generator. However, this could not be tested.
     
    randomBits is defined to be the number of bits returned by a call to
    random(). For most all machines with 32-bit integers, this is 31 bits
    as currently set. 
     
    The routines defined in this file are:
     
      init: defines terminator and initializes the random bit source 
     
      newList: returns a new, empty list 
     
      freeList(l): deallocates the list l
     
      randomLevel: Returns a random level
     
      insert(l,key,value): inserts the binding (key,value) into l. If 
            allowDuplicates is undefined, returns true if key was newly 
            inserted into the list, false if key already existed
     
      delete(l,key): deletes any binding of key from the l. Returns
            false if key was not defined.
     
      search(l,key,value): Searches for key in l and returns true if found.
            If found, the value associated with key is stored in value
     
    *}
     
     
    program test(input,output);
     
    const 
       sampleSize = 65536;
     
       (* The following constants are associated with the random number generator *)
       differentRandoms = 1073741824; (* 2^30 *)
       randomTableSize = 31; (* size of table used *)
     
       (* The follow constants are associated with the routines to procedure
            random levels *)
       ChunkSize = 4; (* ChunkSize = 1/p *)
       randomChucksInAWord = 15; (* = log(base ChunkSize) differentRandoms *)
       MaxLevel = 16;
     
     
    type 
      randomStuff = 0..maxint;
      keyType= 0..maxint;
      valueType = 0..maxint;
      levelNum = 1..MaxLevel;
      node = ^nodeRec;
      list = ^listRec;
      listRec = record
            level : integer;
            header : node;
            end;
      nodeRec = record
          key: keyType;
          value: valueType;
          case levelNum of
            1: (fwd1: array [1..1] of node;);
            2: (fwd2: array [1..2] of node;);
            3: (fwd3: array [1..3] of node;);
            4: (fwd4: array [1..4] of node;);
            5: (fwd5: array [1..5] of node;);
            6: (fwd6: array [1..6] of node;);
            7: (fwd7: array [1..7] of node;);
            8: (fwd8: array [1..8] of node;);
            9: (fwd9: array [1..9] of node;);
           10: (fwd10: array [1..10] of node;);
           11: (fwd11: array [1..11] of node;);
           12: (fwd12: array [1..12] of node;);
           13: (fwd13: array [1..13] of node;);
           14: (fwd14: array [1..14] of node;);
           15: (fwd15: array [1..15] of node;);
           16: (fwd: array [1..16] of node;)
          end;
     
    var randomChunksLeft : integer;
      randomBits : randomStuff;
      l : list;
      i,k : integer;
      v : valueType;
      keys : array [1..sampleSize] of keyType;
      terminator:node;
     
      head,tail : integer;
      randomTable : array[1..31] of randomStuff;
     
     
    function randomNumber: integer;
    begin
      randomTable[head] := (randomTable[head] + randomTable[tail]) 
                                    mod differentRandoms;
      head := (head  mod randomTableSize) + 1;
      tail := (tail mod randomTableSize) + 1;
      randomNumber := randomTable[head];
    end;
     
    procedure initRandom;
    begin
      head := 4;
      tail := 1;
      randomTable[1] := 1005175229;
      randomTable[2] := 143302914;
      randomTable[3] := 1027100827;
      randomTable[4] := 879468478;
      randomTable[5] := 755253631;
      randomTable[6] := 928858961;
      randomTable[7] := 331648406;
      randomTable[8] := 45248011;
      randomTable[9] := 26209743;
      randomTable[10] := 433832350;
      randomTable[11] := 944843483;
      randomTable[12] := 438263339;
      randomTable[13] := 813528929;
      randomTable[14] := 629457392;
      randomTable[15] := 618906479;
      randomTable[16] := 573714703;
      randomTable[17] := 766270699;
      randomTable[18] := 275680090;
      randomTable[19] := 436578616;
      randomTable[20] := 509842102;
      randomTable[21] := 649659208;
      randomTable[22] := 891701505;
      randomTable[23] := 24441858;
      randomTable[24] := 562763940;
      randomTable[25] := 980071615;
      randomTable[26] := 1011597961;
      randomTable[27] := 643279273;
      randomTable[28] := 241719451;
      randomTable[29] := 157584038;
      randomTable[30] := 1069844923;
      randomTable[31] := 471560540;
    end;
     
     
    function randomLevel:integer;
    var newLevel : integer;
        shiftedBits : randomStuff;
        done : boolean;
     
     
    begin
      newLevel := 0;
      done := false;
      repeat
            shiftedBits := randomBits div ChunkSize;
            done := (shiftedBits * ChunkSize) <> randomBits;
            newLevel := newLevel + 1;
            randomBits := shiftedBits;
            randomChunksLeft := randomChunksLeft -1;
            if randomChunksLeft = 0 then 
               begin
                    randomBits := randomNumber;
                    randomChunksLeft := randomChucksInAWord; 
                end;
            until done;
       if newLevel > MaxLevel then newLevel := MaxLevel;
       randomLevel := newLevel;
    end;
     
     
    procedure init;
    begin
      new(terminator,1);
      terminator^.key := (256*256*256*64-1)*2+1;
      randomBits := randomNumber;
      randomChunksLeft := randomChucksInAWord;
    end;
     
    function newList:list;
    var l : list;
        i : integer;
    begin
      new(l);
      l^.level := 1;
      new(l^.header,MaxLevel);
      for i := 1 to MaxLevel do l^.header^.fwd[i] := terminator;
      newList := l;
    end;
     
    procedure freeList(l:list);
    var
      k : levelNum;
      done : boolean;
      p : node;
     
    begin
      p := l^.header^.fwd[1];
      while (p <> terminator) do begin
        k := 1;
        done := false;
        while not done do begin
            l^.header^.fwd[k] := p^.fwd[k];
            k := k+1;
            if k > l^.level then done := true 
            else done := l^.header^.fwd[k] <> p;
            end;
        case k-1 of 
            1 : dispose(p,1);
            2 : dispose(p,2);
            3 : dispose(p,3);
            4 : dispose(p,4);
            5 : dispose(p,5);
            6 : dispose(p,6);
            7 : dispose(p,7);
            8 : dispose(p,8);
            9 : dispose(p,9);
           10 : dispose(p,10);
           11 : dispose(p,11);
           12 : dispose(p,12);
           13 : dispose(p,13);
           14 : dispose(p,14);
           15 : dispose(p,15);
           16 : dispose(p,16)
           end;
          p := l^.header^.fwd[1];
        end;
      dispose(l^.header,MaxLevel);
      dispose(l);
    end;
     
    procedure insert(l:list;key:keyType;value:valueType);
    var
      k : levelNum;
      update : array[1..MaxLevel] of node;
      p,q : node;
     
    begin
      p := l^.header;
     
      for k:= l^.level downto 1 do begin
            q := p^.fwd[k];
            while q^.key < key do begin
                    p := q;
                    q := p^.fwd[k];
                    end;
            update[k] := p;
            end;
     (* The insert routine currently allows duplicate entries. To make
        it update previous entries instead, put in the following code:
     
         if q^.key == key then begin
           q^.value = value;
           end;
         else
     *)
     
       begin
     
     
        k := randomLevel;
        if k>l^.level then begin
            k := l^.level+1;
            l^.level := k;
            update[k] := l^.header;
            end;
     
        case k of 
            1 : new(q,1);
            2 : new(q,2);
            3 : new(q,3);
            4 : new(q,4);
            5 : new(q,5);
            6 : new(q,6);
            7 : new(q,7);
            8 : new(q,8);
            9 : new(q,9);
           10 : new(q,10);
           11 : new(q,11);
           12 : new(q,12);
           13 : new(q,13);
           14 : new(q,14);
           15 : new(q,15);
           16 : new(q,16)
           end;
        q^.key := key;
        q^.value := value;
     
        for k := k downto 1 do begin
            p := update[k];
            q^.fwd[k] := p^.fwd[k];
            p^.fwd[k] := q;
            end;
        end;
    end;
     
    procedure delete(l:list;key:keyType);
    var
      k : levelNum;
      update : array[1..MaxLevel] of node;
      p,q : node;
      done : boolean;
     
    begin
      p := l^.header;
     
      for k:= l^.level downto 1 do begin
            q := p^.fwd[k];
            while q^.key < key do begin
                    p := q;
                    q := p^.fwd[k];
                    end;
            update[k] := p;
            end;
     
      if (q^.key = key) then begin
        k := 1;
        done := false;
        while not done do begin
            update[k]^.fwd[k] := q^.fwd[k];
            k := k+1;
            if k > l^.level then done := true 
            else done := update[k]^.fwd[k] <> q;
            end;
     
        case k-1 of 
            1 : dispose(q,1);
            2 : dispose(q,2);
            3 : dispose(q,3);
            4 : dispose(q,4);
            5 : dispose(q,5);
            6 : dispose(q,6);
            7 : dispose(q,7);
            8 : dispose(q,8);
            9 : dispose(q,9);
           10 : dispose(q,10);
           11 : dispose(q,11);
           12 : dispose(q,12);
           13 : dispose(q,13);
           14 : dispose(q,14);
           15 : dispose(q,15);
           16 : dispose(q,16)
           end;
        end;
    end;
     
    function search(l : list; key : keyType; var value : valueType) : boolean;
    var k : integer;
      p,q : node;
    begin
      p := l^.header;
      for k:= l^.level downto 1 do begin
            q := p^.fwd[k];
            while q^.key < key do begin
                    p := q;
                    q := p^.fwd[k];
                    end;
            end;
        if (q^.key <> key) then search := false
        else begin
           value := q^.value;
           search := true;
           end;
    end;
     
    begin
      initRandom;
      init;
     
      l := newList;
     
      for k := 1 to sampleSize do begin
            keys[k]:=randomNumber;
            insert(l,keys[k],keys[k]);
            end;
     
      for i := 1 to 4 do begin
            for k := 1 to sampleSize do
                if not search(l,keys[k],v) then writeln('not found');
            for k := 1 to sampleSize do begin
                delete(l,keys[k]);
                keys[k] := randomNumber;
                insert(l,keys[k],keys[k]);
                end;
            end;
     
      freeList(l);
     
    end.

