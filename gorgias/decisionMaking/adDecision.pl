:- compile('../lib/gorgias').
:- compile('../ext/lpwnf').
:- compile('./predicates.pl').
:- compile('./bids.pl').
:- dynamic check-price/1,match-interests/1,blockedbypublisher/1,match-geography/1,ad/4,sex/1,age/1,
                   geography/1,categorybysex/2,categorybyage/2,check-age/1,check-sex/1,policy/1,adList/1,adListUpdate/1,check/2.

%%%%%%%%%%%% FUNCTIONS %%%%%%%%%%%%%%%%%%%%

match-interests(B):-ad(B,I,_,_),interests(I).

match-geography(B):-ad(B,_,_,G),geography(G).

check-price(B):-adList(Z),check(B,Z).

check(_,[]).

check(B,[Z|Zs]):-ad(B,_,P1,_),ad(Z,_,P2,_),B=\=Z,ad(Z,_,P2,_)->P1>=P2,check(B,Zs);
                                           check(B,Zs).

%%% check-age(B):-ad(B,I,_,_),age(A),categorybyage(I,A). %%%

% check-sex(B):-ad(B,I,_,_),sex(S),categorybysex(I,S).

% categorybyage(I,A):-    A>=10,A<15 -> (I=sports; I=entertainment; I=pets);
%                        A>=15,A<20->(I=sports;I=entertainment;I=clothes;I=cosmetics;I=food;I=technology;I=pets);
%                        A>=20,A<40->(I=entertainment;I=clothes;I=food;I=cosmetics;I=travelling;I=technology;I=cars;I=sports;I=pets);
%                        A>=40,A<60->(I=clothes;I=food;I=cosmetics;I=travelling;I=health);
%                        A>=60,A<80->(I=health;I=food).
						
% categorybysex(I,S):-    S==female ->(I=health;I=food;I=pets;I=cosmetics;I=entertainment;I=travelling;I=sports;I=technology;I=clothes);
                       % S==male->(I=health;I=food;I=pets;I=cars;I=entertainment;I=travelling;I=sports;I=technology).

%%%%%%%%%%%%%%% OPTIONS THAT ARE AGAINST %%%%%%%%%%% 						
										
complement(show(ad,X),show(ad,I)):-adList(Z),member(I,Z),member(X,Z),X=\=I,ad(X,_,_,_),ad(I,_,_,_).



% Arguments for Options

%%%%%%%%%%%%%%% OPTIONS BUT CHECKS IF THE AD EXISTS OR IF IT IS BLOCKED %%%%%%%%%%% 

rule(r(ad,I), show(ad,I), []):-adList(Z),member(I,Z),ad(I,_,_,_).

% Normal Policy
 
%%%%%%%%%%%%%%%%%%% 001 PREFER AD ON USER GEOGRAPGY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

rule(g(ad,X), prefer(r(ad,X),r(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I,match-geography(X),not(match-interests(X)),not(check-price(X)).

%%%%%%%%%%%%%%%%%%%% 010 PREFER AD WITH HIGHPRICE %%%%%%%%%%%%%%%%%

rule(h(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,check-price(X),not(match-interests(X)),not(match-geography(X)).


%%%%%%%%%%%%%%%%%%%% 011 PREFER AD WITH HIGHPRICE AND GEOGRAPHY %%%%%%%%%%%%%%%%%

rule(hg(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,check-price(X),match-geography(X),not(match-interests(X)).

%%%%%%%%%%%% 100 PREFER ADS ON USER INTERESTS %%%%%%%%%%%%%%%%%%%%

rule(i(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,match-interests(X),not(match-geography(X)),not(check-price(X)).

%%%%%%%%%%%%%%%%%%%% 101 PREFER AD WITH USER INTERESTS AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%

rule(ig(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,match-interests(X),match-geography(X),not(check-price(X)).


%%%%%%%%%%%%%%%%%%%% 110 PREFER AD WITH USER INTERESTS HIGHPRICE %%%%%%%%%%%%%%%%%

rule(ih(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,match-interests(X),check-price(X),not(match-geography(X)).


%%%%%%%%%%%%%%%%%%%% 111 PREFER AD WITH USER INTERESTS HIGHPRICE AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%

rule(ihg(ad,X), prefer(r(ad,X),r(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I,match-interests(X),check-price(X),match-geography(X).





%%%%%%%%%%% PRIORITY INTERESTS,HIGHPRICE,GEOGRAPHY %%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%% POLICY 1,3 %%%%%%%%%%%%%%%%%%


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),h(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pi(ad,X), prefer(i(ad,X),h(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE AND USER GEOGRAPGY %%%%%%%%%%%%%%%%%%

rule(pi(ad,X), prefer(i(ad,X),hg(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),i(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),h(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 101 PREFER ADS WITH USER INTER0ESTS AND GEOGRAPHY THAN HIGHPRICE AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),hg(ad,I)),[]):-policy(P),(P==1;P==3),adList(Z),member(X,Z),member(I,Z),X=\=I.




%%%%%%%%%%% PRIORITY HIGHPRICE,INTERESTS,GEOGRAPHY %%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%% POLICY 2 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(ph(ad,X), prefer(h(ad,X),i(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS AND GEOGRAPHY  %%%%%%%%%%%%%%%%%%

rule(ph(ad,X), prefer(h(ad,X),ig(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),i(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% KOINO 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),h(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),ig(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%%%%%% PRIORITY INTERESTS,GEOGRAPHY,HIGHPRICE %%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%% POLICY 3 %%%%%%%%%%%%%%%%%%


%%%%%%% 001 PREFER ADS WITH GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pg(ad,X), prefer(g(ad,X),h(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 011 PREFER ADS WITH GEOGRAPHY AND HIGHPRICE THAN ONLY HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),g(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 100 PREFER ADS WITH USER INTERESTS THAN HIGHPRICE,GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pi(ad,X), prefer(i(ad,X),g(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(ad,X), prefer(ih(ad,X),g(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),g(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 101 PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS AND HIGHPRICE %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),ih(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.




%%%%%%%%%%%%%%%%%%%%%%%%%%%% POLICY 1,2,3 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(pih(ad,X), prefer(ih(ad,X),h(ad,I)),[]):-policy(P),(P==1;P==2;P==3)->adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pih(ad,X), prefer(ih(ad,X),i(ad,I)),[]):-policy(P),(P==1;P==2;P==3)->adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN USER INTERESTS AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(ad,X), prefer(ih(ad,X),ig(ad,I)),[]):-policy(P),(P==1;P==2)->adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 110 PREFER ADS WITH USER INTERESTS AND HIGHPRICE THAN HIGHPRICE AND USER GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(pih(ad,X), prefer(ih(ad,X),hg(ad,I)),[]):-policy(P),(P==1;P==2;P==3)->adList(Z),member(X,Z),member(I,Z),X=\=I.



%%%%%%%%%%%%%%%%%%%% POLICY 1,2,3 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),i(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),h(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER GEOGRAPHY AND HIGHPRICE %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),hg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS AND HIGHPRICE %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),ih(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER INTERESTS AND GEOGRAPHY %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),ig(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

%%%%%%%%%%%%%%%%%%%%% 111  PREFER ADS WITH USER INTEERESTS HIGHPRICE AND USER GEO THAN USER GEOGRAPHY %%%%%%%%%%%%%%%%%%%

rule(pihg(ad,X), prefer(ihg(ad,X),g(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.



