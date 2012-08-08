  $( document ).ready( function(){
    var keyPad = $( '#keypad' );
    var resultsDisplay = $( '#results' );
    var banterDisplay = $( '#banter' );
    var calculon = function(){
        var allMyCircuits = {};
        var clearThis = function(){
              var init = {
               memory   : ( function(){
                             var myMem = {
                               havingMems : false
                             };
                             myMem.update = function( data, callback ){
                              try{
                                if( data.M.length < 1 && data.operator !== 'MR' ){
                                  return false;
                                }
                                if( data.operator == 'MC' ){
                                  clearInterval( myMem.fondMems );
                                }
                                
                                $.post(
                                  'calculon/result'
                                  ,data
                                  ,function( Response ){
                                    myMem.havingMems = Response.memory != '0';
                                    if( typeof callback === 'function' ){
                                      callback( Response );
                                    }
                                    if( myMem.havingMems == true ){
                                      $( "#memorybench" ).addClass('inuse');
                                    }
                                    else{
                                      $( "#memorybench" ).removeClass('inuse');
                                    }
                                    return myMem;
                                  }
                                  ,'json');
                              }
                              catch( Err ){}
                            }
                             
                           myMem.fondMems = ( function(){
                               return setInterval( function(){
                                 if( myMem.havingMems ){
                                   myMem.update(
                                          {
                                            M:true
                                            ,operator:'MR'
                                          }
                                          , function( Response ){
                                                 $('#fondMems').html( "<div>Ah, my memories of</div><div id=\"damem\">" + Response.memory + "</div>")
                                                    .fadeIn( '200', function(){
                                                     setTimeout( function(){
                                                       $('#fondMems').fadeOut( '300' );
                                                     }, 4000 );
                                                   });
                                   })
                                 }
                               }, 10000 );
                             }()); 
                             myMem.update({operator:"MR",M:true});
                             return myMem;
               }())
               ,values : function(){
                 return {
                   value : '0'
                   ,clean : function(){
                     return this.value = '0';
                   }
                   ,store : function( value ){
                     return this.value = ( this.value.substr(0,1) == '0' || !this.isdec() )
                                      ? this.value.substr(1, this.value.length ) + value
                                      : this.value + value;
                   }
                   ,invert : function(){
                     return this.value = ( this.value.substr(0,1) == '-' )
                                      ? this.value.substr(1, this.value.length )
                                      : ( this.value.substr(0,1) == '0' )?this.value:'-' + this.value;
                   }
                   ,dec : function(){
                          
                              return this.value = ( this.isdec )
                                        ? this.value + "."
                                        : this.value;

                   },
                   isdec : function(){
                     var regEx = /[\.]/;
                     return regEx.test( this.value );
                   }
                   
                }
               }
              ,varA : false
              ,varB : false
              ,currOperator : ''
              ,Operator : ''
              ,processing : false
              ,use_var_A : true
              ,C : function(){
                
              }
              ,switchVar : function(){
                  this.use_var_A = !this.use_var_A;
                  return this;
              }
              ,operator : function( value ){
                
                  if( value == "M+" || value == "M-" || value == "MR" ){
                    return this.memory.update({
                        operator : value
                        ,M       : resultsDisplay.html()
                      }
                      , function( response ){
                        workingMem.activeVar().store( response.memory );
                        workingMem.clear('C');
                        resultsDisplayUpdate( response.memory );
                      });
                  }

                  this.Operator = value;
                  if( this.use_var_A === false && this.varB.value != '0' ){
                    return allMyCircuits.process( this.currOperator );
                  }
                  if( this.use_var_A == true ){
                    this.switchVar();
                  }
                  this.currOperator = this.Operator;
                  return this.Operator;
              }
              ,activeVar : function(){
                return ( this.use_var_A )?this.varA:this.varB; 
              }
              ,store : function( value ){

                        var dispVal ="Error";
                        
                        if( value === '+/-' ){
                          dispVal = this.activeVar().invert( value );
                        }
                        else if( value === '.' ){
                          dispVal = this.activeVar().dec( value );
                        }
                        else{
                          dispVal = this.activeVar().store( value );
                        }
                        
                        var dispValstartChar = resultsDisplay.html().substr(0,1);
                        return resultsDisplayUpdate( dispVal )
                        
                        var inverter = function(){
                          if( dispValstartChar == '-' ){
                            dispVal = resultsDisplay.html().substr(1, resultsDisplay.html() );
                          }
                          else{
                            resultsDisplay.html( "-" + resultsDisplay.html() );
                          }
                          this.value = resultsDisplay.html();
                          
                          return this.value;
                        }
                        
                        var append = function(){
                          if( dispValstartChar == '0' ){
                            return this.value;
                          }
                          this.value += value;
                          return this.value;
                        }

                
                        resultsDisplayUpdate( dispVal )
              }
              
              ,clear : function( clearWhat ){
                var cleaner = {
                      C : function(){
                      if( workingMem.use_var_A ){
                        workingMem.varA.clean();
                      }
                      else{
                        workingMem.varB.clean();
                      }
                      return workingMem;
                      }
                      ,CE : function(){
                        workingMem.memory.update({
                          operator : clearWhat
                          ,M        : true
                        }, function(){
                          workingMem = clearThis();
                        });

                      }
                      ,MC : function(){
                        return workingMem.memory.update({
                          operator : clearWhat
                          ,M        : true
                        }, function(){
                          clearInterval( workingMem.memory.fondMems );
                          workingMem.memory.havingMems = false;
                        });
                      }              
                    }
                if( typeof cleaner[clearWhat] === 'function' ){
                  resultsDisplay.html('0');
                  return cleaner[ clearWhat ]();
                }
              }
            }
            init.varA = init.values();
            init.varB = init.values();
            return init;
        };
        var workingMem = clearThis();

        allMyCircuits.process = function( ){
          var response = {
            message : "Actually you failed to enter some parts.<br/> But since the answer to Live, the universe and everything is 42, I'll give you that.<br />"
          };
          var Success = function(){
                          workingMem.use_var_A = true;
                          workingMem.activeVar().clean();
                          workingMem.activeVar().store( response.result ) //store the result value in A
                          workingMem.use_var_A = false;
                          resultsDisplayUpdate( response.result );
                          workingMem.varB.clean();              //clear B
                          allMyCircuits.banter( response.message );
                          workingMem.processing = false;
          }
          var Failure = function(){
                          workingMem.use_var_A = true;
                          workingMem.activeVar().clean();
                          workingMem.activeVar().store( response.result ) //store the result value in A
                            workingMem.use_var_A = true;
                            resultsDisplay.html( '?? 42 ??' );
                            workingMem.processing = false;
                            return allMyCircuits.banter( response.message );
          }
          
          if( workingMem.varA.length == 0 
            || workingMem.varB.length == 0 
            || workingMem.Operator.length == 0 ){
            return false;
          }
          resultsDisplayUpdate( '----' );
          workingMem.processing = true;
          $.post(
            '/calculon/result',
            {
               inputA    : workingMem.varA.value
              ,inputB   : workingMem.varB.value
              ,operator : workingMem.currOperator
            }
            ,function( Response ){
              response = Response;
              if( response.success ){
                return Success();
              }
              else{
                return Failure();
              }
            }
            ,'json'
          );
        }
        
        allMyCircuits.banter = function( banterMessage, append ){
          var currBanter = ( Boolean( append ) == false )?"":resultsDisplay.html('');
          banterDisplay.html( currBanter + banterMessage ).show();
          setTimeout( function(){
            banterDisplay.fadeOut( '500', function(){
              $(this).html('');
            });
          }, 5000 );
        };
        
        var resultsDisplayUpdate = function( resultsUpdateValue, append ){
          var currDispl = ( Boolean( append ) == false )?'':resultsDisplay.html();         
          resultsDisplay.html( currDispl + resultsUpdateValue );
        };
        
        var control = function( e ){
          var myKey = e.target;
          (function(){
              $('.operator').each( function(){
                $(this).removeClass('active');
              });
          }());
          
          
          if( myKey === this ){
            allMyCircuits.banter("I'm guessing your eye-hand co&ouml;rdination needs some work.");
            return false;
          }
          
          var keyPressed = myKey.textContent.trim();
          
          if( workingMem.processing === true && keyPressed != 'CE' ){
            allMyCircuits.banter("Hold on for just a second, I'm re-arranging my bytes.");
            return false;
          }
          if( $( myKey ).hasClass('operator' ) ){
              $( myKey ).addClass('active');
              workingMem.operator( keyPressed );
              return workingMem;
          }
          
          var regExNum = /^(\d)|(\.)|(\+\/\-)$/;
          if( regExNum.test( keyPressed ) ){
              var dispVal = workingMem.store( keyPressed );
              return workingMem;
          }
          var regExClr = /^(C)|(MC)+$/;
          if( regExClr.test( keyPressed ) ){
              workingMem.clear( keyPressed );
              return false;
          }
          var regExMem = /^(M.+)$/;
          if( regExMem.test( keyPressed ) ){
              workingMem.operator( keyPressed );
              return workingMem;
          }
          var regExRes = /^(\=)/;
          if( regExRes.test( keyPressed ) ){
              allMyCircuits.process();
          }
          return false;
        }
        
        var display = (function( elem ){
          var dispElemCurrClass = document.getElementById('resultdisplay').className;
          
          elem.children('li').hover(
            function( e ){
              document.getElementById('resultdisplay').className = e.target.className;
              elem.bind( 'click', function( e ){
                dispElemCurrClass = e.target.className
              });
            },
            function(e){
              document.getElementById('resultdisplay').className = dispElemCurrClass;
              elem.unbind( 'click' );
            }
          );
          
        }( $('#display') ) );
        
        keyPad.bind( 'click', control );
        return allMyCircuits.banter("I'm caculon, you may have seen me on <em>\"All my circuits\"</em>\n\
<br />Today I'm here to serve you, and enjoy some wine and friendly banter.");
    }
    
    calculon();
  });