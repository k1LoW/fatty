$(function(){
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
  });