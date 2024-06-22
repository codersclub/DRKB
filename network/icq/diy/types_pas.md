---
Title: Модуль Types.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---


Types.pas
=========

статья: [ICQ2000 - сделай сам](./)

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Author:       Alexander Vaga
    EMail:        alexander_vaga@hotmail.com
    Creation:     May, 2002
    Legal issues: Copyright (C) 2002 by Alexander Vaga
                  Kyiv, Ukraine
     
                  This software is provided 'as-is', without any express or
                  implied warranty.  In no event will the author be held liable
                  for any  damages arising from the use of this software.
     
                  Permission is granted to anyone to use this software for any
                  purpose, including commercial applications, and to alter it
                  and redistribute it freely.
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
     
    unit Types;
    interface
     
    const
     STATE_ONLINE     =$10020000;
     STATE_AWAY       =$10020001;
     STATE_DND        =$10020013;
     STATE_INVISIBLE  =$10020100;
     STATE_OCCUPIED   =$10020011;
     STATE_FREEFORCHAT=$10020020;
     STATE_N_A        =$10020005;
     
     TYPE_MSG         =$01;
     TYPE_CHAT        =$02;
     TYPE_FILE        =$03;
     TYPE_URL         =$04;
     TYPE_AUTH_REQ    =$06;
     TYPE_AUTH_DEN    =$07;
     TYPE_AUTH_GIV    =$08;
     TYPE_ADDED       =$0C;
     TYPE_WEBPAGER    =$0D;
     TYPE_EXPRESS     =$0E;
     TYPE_CONTACT     =$13;
     TYPE_CONTACT_REG =$1A;
     
          online      = 0;
          freeforchat = 1;
          invisible   = 2;
          occupied    = 3;
          dnd         = 4;
          away        = 5;
          na          = 6;
          etc         = 7;
          offline     = 8;
          simply_icq  = 9;
          mes         = 10;
          empty       = 11;
     
     PACKET_DATA_SIZE = 4096;
    type
       IParray = array[0..3] of byte;
       PByteArray = ^TByteArray;
       TByteArray = array[0..PACKET_DATA_SIZE-1] of byte;
       PCharArray = ^TCharArray;
       TCharArray = array[0..PACKET_DATA_SIZE-1] of char;
       PWORD = ^word;
       PLONG = ^longint;
       PBYTE = ^byte;
     
    type PFLAP_HDR = ^FLAP_HDR;
         FLAP_HDR = packed record
           Sign : byte;
           ChID : byte;
           SEQ  : word;
           Len  : word;
         end;
     
    type PSNAC_HDR = ^SNAC_HDR;
         SNAC_HDR = packed record
           FamilyID  : word;
           SubTypeID : word;
           Flags     : array[0..1] of byte;
           RequestID : longint;
         end;
     
    type PFLAP_Item = ^FLAP_Item;
         FLAP_Item = packed record
           FLAP : FLAP_HDR;
           DATA : PByteArray;
           Next : PFLAP_Item;
         end;
     
    type
       Pack = packed record
          cursor : word;
          length : word;
          case integer of
            0: (DATA:array[0..PACKET_DATA_SIZE-1] of byte);
            1: (FLAP : FLAP_HDR;
                FLAP_BODY:array[0..PACKET_DATA_SIZE-1] of byte);
            2: (Sign,ChID:byte;  SEQ,Len  : word);
            3: (fix:FLAP_HDR;
                SNAC:SNAC_HDR;
                SNAC_BODY:array[0..PACKET_DATA_SIZE-1] of byte);
        end;
       PPack = ^Pack;
     
    implementation
     
    end.
     
     
     
     
     
