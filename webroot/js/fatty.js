$(function(){

      $('#autopaging').live('click',function() {
                                var $self = $(this);
                                var url = $(this).find('a').attr('href');
                                $(this).find('a').removeAttr('href');

                                // loading
                                var $img = $('<img>').attr({id:'loading',
                                                            src:fattyBase + 'img/loading.gif'});
                                $self.html('').append($img);
                                $.get(url, function (res) {
                                          $('#content').append(res);
                                          $self.remove();
                                          init();
                                      });
                            });

      function init () {
          var a = null;
          var b = null;
          $('.draggable').draggable({
                                        start: function(event, ui) {
                                            var $self = $(this);
                                            a = $(this).attr('id');
                                            $self.css({zIndex:10});
                                            $self.siblings('.draggable').css({zIndex:9});
                                        },
                                        end: function(event, ui) {
                                            a = null;
                                        },
                                        axis: 'y',
                                        revert: true,
                                        opacity: 0.7
                                    });
          $('.droppable').droppable({
                                        greedy: true,
                                        hoverClass: 'dropHover',
                                        drop: function(event, ui) {
                                            var $self = $(this);
                                            b = $(this).attr('id');
                                            location.href = fattyBase + 'diff/' + a + '/' + b;
                                        }
                                    });

          $('div#container').dblclick(function(){
                                          var action = 'tree';

                                          if (location.href.match(/tree/)) {
                                              action = 'index';
                                          }

                                          location.href = fattyBase + action;
                                      });
      }

      init();
  });