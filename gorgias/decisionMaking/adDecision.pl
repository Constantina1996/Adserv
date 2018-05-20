:- compile('../lib/gorgias').
:- compile('../ext/lpwnf').
:- compile('./predicates.pl').
:- compile('./bids.pl').
:- compile('./policy.pl').

:- dynamic checkprice/1,matchinterests/1,matchgeography/1,ad/4,sex/1,age/1,
                   geography/1,categorybysex/2,categorybyage/2,checkage/1,checksex/1,policy/1,check/2.

                               
%%%%%%%%%%%% FUNCTIONS %%%%%%%%%%%%%%%%%%%%

matchinterests(B):-ad(B,I,_,_),interests(I).

matchgeography(B):-ad(B,_,_,G),geography(G).

checkprice(B):-adList(Z),check(B,Z).

check(_,[]).

check(B,[Z|Zs]):-ad(B,_,P1,_),ad(Z,_,P2,_),B=\=Z,ad(Z,_,P2,_)->P1>=P2,check(B,Zs);
																		check(B,Zs).

checkage(B):-ad(B,I,_,_),age(A),A\='undefined'->categorybyage(I,A). 

checksex(B):-ad(B,I,_,_),sex(S),S\='undefined'->categorybysex(I,S).

categorybyage(I,A):- A>=0,A=<10->(I=sports;I=entertainment;I=pets; I=art);
 
                     A>=11,A=<18->(I=videogames;I=sports;I=entertainment;I=fashionandstyle;I=computersandtechnology;I=pets;I=education;I=science);

                     A>=19,A=<25->(I=personalcare;I=entertainment;I=fashionandstyle;I=food;I=beauty;I=travel;I=computerandtechnology;I=cars;I=sports;I=pets;I=business;I=fitness;I=news;I=videogames;I=drinks;I=education;I=science);
                            
                     A>=26,A=<40->(I=personalcare;I=entertainment;I=fashionandstyle;I=food;I=beauty;I=travel;I=computerandtechnology;I=cars;I=sports;I=pets;I=business;I=fitness;I=news;I=health;I=familyandparenting;I=weddings;I=homeandgarden;I=drinks);
                            
                     A>=40,A=<60->(I=beauty;I=food;I=travel;I=health;I=personalcare;I=drinks;I=homeandgarden;I=familyandparenting;I=cars);
                            
                     A>=60->(I=health;I=food;I=art;I=personalcare;I=homeandgarden).
						
categorybysex(I,S):-    S== fe->(I=fashionandstyle;I=personalcare;I=beauty);
						S== ma ->(I=motorcycles;I=videogames).
						
%%%%%%%%%%%%%%% OPTIONS THAT ARE AGAINST %%%%%%%%%%% 						
										
complement(show(X),show(I)):-ad(X,_,_,_),ad(I,_,_,_),X=\=I.


% Arguments for Options

%%%%%%%%%%%%%%% OPTIONS BUT CHECKS IF THE AD EXISTS OR IF IT IS BLOCKED %%%%%%%%%%% 

rule(r(X), show(X), []):-ad(X,_,_,_).


% Normal Policy
 

%%%%%%%%%%%%%%%%%%%% 111 PREFER AD WITH USER INTERESTS HIGHPRICE AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%

rule(ihg(X,I), prefer(r(X),r(I)),[]):-matchinterests(X),ad(I,_,_,_),X=\=I,checkprice(X),matchgeography(X).

%%%%%%%%%%%%%%%%%%%% 110 PREFER AD WITH USER INTERESTS HIGHPRICE %%%%%%%%%%%%%%%%%

rule(ih(X,I), prefer(r(X),r(I)),[]):-matchinterests(X),ad(I,_,_,_),X=\=I,checkprice(X),not(matchgeography(X)).


%%%%%%%%%%%%%%%%%%%% 101 PREFER AD WITH USER INTERESTS AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%

rule(ig(X,I), prefer(r(X),r(I)),[]):- matchinterests(X),matchgeography(X),ad(I,_,_,_),X=\=I,not(checkprice(X)).


%%%%%%%%%%%% 100 PREFER ADS ON USER INTERESTS %%%%%%%%%%%%%%%%%%%%

rule(i(X,I), prefer(r(X),r(I)),[]):-matchinterests(X),not(matchgeography(X)),ad(I,_,_,_),X=\=I,not(checkprice(X)).


%%%%%%%%%%%%%%%%%%%% 011 PREFER AD WITH HIGHPRICE AND GEOGRAPHY %%%%%%%%%%%%%%%%%

rule(hg(X,I), prefer(r(X),r(I)),[]):-matchgeography(X),ad(I,_,_,_),X=\=I,checkprice(X),not(matchinterests(X)).

%%%%%%%%%%%%%%%%%%%% 010 PREFER AD WITH HIGHPRICE %%%%%%%%%%%%%%%%%

rule(h(X,I), prefer(r(X),r(I)),[]):- not(matchinterests(X)),ad(I,_,_,_),X=\=I,checkprice(X),not(matchgeography(X)).

%%%%%%%%%%%%%%%%%%% 001 PREFER AD ON USER GEOGRAPGY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

rule(g(X,I), prefer(r(X),r(I)),[]):- policy(3),matchgeography(X),not(matchinterests(X)),ad(I,_,_,_),X=\=I,not(checkprice(X)).


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% PRIORITY INTERESTS,HIGHPRICE,GEOGRAPHY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


%%%%%%%%%%%%%%%%%%%% POLICY 1,2,3 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),i(I,X)),[]).


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),h(I,X)),[]).



%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER GEOGRAPHY AND HIGHPRICE %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),hg(I,X)),[]).


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS AND HIGHPRICE %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),ih(I,X)),[]).


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS AND GEOGRAPHY %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),ig(I,X)),[]).


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER GEOGRAPHY %%%%%%%%%%%%%%%%%%%

rule(pihg(X,I), prefer(ihg(X,I),g(I,X)),[]).



%%%%%%%%%%%%%%%%%%%% POLICY 1%%%%%%%%%%%%%%%%%%

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),h(I,X)),[]):-policy(1).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),i(I,X)),[]):-policy(1).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),ig(I,X)),[]):-policy(1).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),hg(I,X)),[]):-policy(1).

%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),i(I,X)),[]):-policy(1).

%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),h(I,X)),[]):-policy(1).


%%%%%%% 101 PREFER ADS WITH USER INTER0ESTS AND GEOGRAPHY THAN HIGHPRICE AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),hg(I,X)),[]):-policy(1).


%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pi(X,I), prefer(i(X,I),h(I,X)),[]):-policy(1).


%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%%

rule(pi(X,I), prefer(i(X,I),hg(I,X)),[]):-policy(1).

%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),h(I,X)),[]):-policy(1).





%%%%%%%%%%%%%%%%%%%% POLICY 2%%%%%%%%%%%%%%%%%%

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),h(I,X)),[]):-policy(2).


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),i(I,X)),[]):-policy(2).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),ig(I,X)),[]):-policy(2).


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),hg(I,X)),[]):-policy(2).


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),i(I,X)),[]):-policy(2).


%%%%%%% KOINO 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),h(I,X)),[]):-policy(2).


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),ig(I,X)),[]):-policy(2).

%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(ph(X,I), prefer(h(X,I),i(I,X)),[]):-policy(2).

%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS AND GEOGRAPHY  %%%%%%%%%%%%%%%%%%

rule(ph(X,I), prefer(h(X,I),ig(I,X)),[]):-policy(2).



%%%%%%%%%%%%%%%%%%%% POLICY 3%%%%%%%%%%%%%%%%%%

%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),i(I,X)),[]):-policy(3).


%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),h(I,X)),[]):-policy(3).


%%%%%%% 101 PREFER ADS WITH USER INTER0ESTS AND GEOGRAPHY THAN HIGHPRICE AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),hg(I,X)),[]):-policy(3).


%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS AND HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),ih(I,X)),[]):-policy(3).


%%%%%%% 100 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pig(X,I), prefer(ig(X,I),g(I,X)),[]):-policy(3).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),h(I,X)),[]):-policy(3).


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),i(I,X)),[]):-policy(3).

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),hg(I,X)),[]):-policy(3).


%%%%%%% 100 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(X,I), prefer(ih(X,I),g(I,X)),[]):-policy(3).

%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pi(X,I), prefer(i(X,I),h(I,X)),[]):-policy(3).


%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%%

rule(pi(X,I), prefer(i(X,I),hg(I,X)),[]):-policy(3).

%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pi(X,I), prefer(i(X,I),g(I,X)),[]):-policy(3).

%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),h(I,X)),[]):-policy(3).

%%%%%%% 011 PREFER ADS WITH GEOGRAPHY AND HIGHPRICE THAN ONLY HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(phg(X,I), prefer(hg(X,I),g(I,X)),[]):-policy(3).

%%%%%%% 001 PREFER ADS WITH GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pg(X,I), prefer(g(X,I),h(I,X)),[]):-policy(3).


%%%%%%%%%%%%%%%%%%%%%% PRIORITY ABOUT AGE AND SEX %%%%%%%%%%%%%%%%%%%%%%%%%%%%


rule(p-ihg(X,I), prefer(ihg(X,I),ihg(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-ihg(X,I), prefer(ihg(X,I),ihg(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-ih(X,I), prefer(ih(X,I),ih(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-ih(X,I), prefer(ih(X,I),ih(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-ig(X,I), prefer(ig(X,I),ig(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-ig(X,I), prefer(ig(X,I),ig(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-i(X,I), prefer(i(X,I),i(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-i(X,I), prefer(i(X,I),i(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-hg(X,I), prefer(hg(X,I),hg(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-hg(X,I), prefer(hg(X,I),hg(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-h(X,I), prefer(h(X,I),h(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-h(X,I), prefer(h(X,I),h(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).

rule(p-gg(X,I), prefer(g(X,I),g(I,X)),[X=\=I]):-checkage(X),not(checkage(I)).
rule(p-gg(X,I), prefer(g(X,I),g(I,X)),[X=\=I]):-checksex(X),not(checksex(I)).
