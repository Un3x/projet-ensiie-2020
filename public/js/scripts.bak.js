// Thomas Meyer <thomasmeyer(at)outlook.com>

"use strict";

/*
 * 
 * MODEL
 * 
 */


/* Constructor
 */
var Model = function () {
    
    // States and transitions
    this.state = [];
    
    // Initial state
    this.initial = -1;
    
    // Accepting states
    this.accepting = [];
    
    // Symbols
    this.symbols = {
        size: 2,
        type: "colors"
    };
    
    // Sequences
    this.sequence = [
        [0, 0],
        [0, 1, 0],
        [0, 1, 1, 0],
        [0, 1, 1, 1, 0]
    ];
    
    // Results
    this.result = [null, null, null, null];
    
};


/* To remove all transitions of a given state
 */
Model.prototype.removeInitialTransitionOfState = function (id) {
    for (var symbol = 0; symbol < this.symbols.size; symbol++) {
        this.state[id].transition[symbol] = null;
    }
};


/* To add a state
 */
Model.prototype.addState = function () {
  
    var id = 0;
    
    // We need to find a free id for the new state
    while (id < this.state.length && this.state[id].exist) {
        id++;
    }
    
    // If we have a free slot, we attribute it to the new state
    if (id < this.state.length) {
        this.state[id].exist = true;
    }
    
    // Otherwise, we need to create a new slot
    else {
        this.state.push({
            exist: true,
            transition: new Array(this.symbols.size)
        });
        this.removeInitialTransitionOfState(id);
    }
    
    // We return the id to be used by View
    return id;
};


/* To remove a state
 */
Model.prototype.removeState = function (id) {
  
    // We remove the given state and its initial transitions
    this.state[id].exist = false;
    this.removeInitialTransitionOfState(id);
    
    // We remove all its final transitions
    for (var from = 0; from < this.state.length; from++) {
        for (var symbol = 0; symbol < this.symbols.size; symbol++) {
            if (this.state[from].transition[symbol] === id) {
                this.state[from].transition[symbol] = null;
            }
        }
    }
    
};


/* To add some transitions
 */
Model.prototype.addTransitions = function (from, to, symbol) {
    for (var i = 0; i < to.length; i++) {
        this.state[from].transition[symbol[i]] = to[i];
    }
};


/* To remove some transitions
 */
Model.prototype.removeTransitions = function (from, symbol) {
    for (var i = 0; i < symbol.length; i++) {
        this.state[from].transition[symbol[i]] = null;
    }
}


/*
 */
Model.prototype.exec = function (seq) {
  
    var current = this.initial;
    var next = null;
    
    for (var symbol = 0; symbol < seq.length; symbol++) {
      
        next = this.state[current].transition[seq[symbol]];
        
        if (next === null) {
            return false;
        }
        
        current = next;
    }
    
    return this.accepting[current];
};


/* 
 */
Model.prototype.getOutputStates = function (id) {
    var outputStates = [];
    for (var symbol = 0; symbol < this.symbols.size; symbol++) {
        if (this.state[id].transition[symbol] !== null) {
            outputStates.push(
                this.state[id].transition[symbol]
            );
        }
    }
    return outputStates;
};


/* 
 */
Model.prototype.getInputStates = function (id) {
    var inputStates = [];
    for (var from = 0; from < this.state.length; from++) {
        for (var symbol = 0; symbol < this.symbols.size; symbol++) {
            if (this.state[from].transition[symbol] === id) {
                inputStates.push(
                    from
                );
            }
        }
    }
    return inputStates;
};


/*
 * 
 * VIEW
 * 
 */


/* Constructor
 */
var View = function () {

    // The stage
    this.stage = new Konva.Stage({
        container: 'container',
        width: 600,
        height: 400
    });
    
    // The layer
    this.layer = new Konva.Layer();
    this.stage.add(this.layer);

    // To know selected state or transition
    this.selectedState = null;
    this.selectedTransition = null;

    // To be able to add a transition by choosing two states
    this.createTransition = false;
    this.from = null;
    this.to = null;
    
    this.states = [];
    this.transitions = [];
    
    // To update view when a state is dragged
    this.updated = false;
    this.inputStates = [];
    this.outputStates = [];
};


/* To add a state
 */
View.prototype.addState = function (id, x, y) {
    
    //
    while (this.states.length <= id) {
        this.states.push(null);
        this.transitions.push([]);
        
        for (var i = 0; i < this.transitions.length; i++) {
            while (this.transitions[i].length < this.states.length) {
                this.transitions[i].push(null);
            }
        }
    }
    
    this.clearDrag();
    
    // A state is represented by a circle
    var circle = new Konva.Circle ({
        id: String(id),
        x: x,
        y: y,
        radius: 20,
        fill: "#007bff",
        draggable: true
    });
    this.states[id] = circle;
    
    // We need to attach a mouse up event to interact with
    circle.on("mousedown", function (e) {
        
        view.clearDrag();
        
        // We mark this state as selected
        view.selectState(e.target);
        
        // If we are creating a transition, we need to choose what to do
        if (view.createTransition) {
          
            // To choose this state as 'from' state
            if (view.from === null) {
                view.from = circle;
            }
            
            // To choose this state as 'to' state and create transition
            else {
                view.to = circle;
                view.addTransition();
            }
            
            $("#remove-state").hide();
            this.selectedState = null;
        }
    });
    
    // We need to attach a drag move event to update view
    circle.on('dragmove', function(e) {
        
        if (!view.updated) {
            view.getTransitionsToUpdate(e.target.getId());
        }
        
        view.updateTransitions(e.target);
        
        view.layer.batchDraw();
    });
  
    // To end, we have to display this circle
    this.layer.add(circle);
    this.layer.batchDraw();
};


View.prototype.clearDrag = function () {
    this.updated = false;
    this.outputStates = [];
    this.inputStates = [];
};


View.prototype.getTransitionsToUpdate = function (id) {
    
    // From transitions
    this.outputStates = model.getOutputStates(Number(id));
    
    // To transitions
    this.inputStates = model.getInputStates(Number(id));
    
    this.updated = true;
};

View.prototype.updateTransitions = function (circle) {
    
    var id = Number(circle.getId());
    
    // To transitions
    for (var to = 0; to < this.outputStates.length; to++) {
        this.transitions[id][this.outputStates[to]].points(
            this.getConnectorPoints(
                circle,
                this.states[this.outputStates[to]]
            )
        );
    }
    
    // From transitions
    for (var from = 0; from < this.inputStates.length; from++) {
        this.transitions[this.inputStates[from]][id].points(
            this.getConnectorPoints(
                this.states[this.inputStates[from]],
                circle
            )
        );
    }
};

View.prototype.removeTransitionsAttachedToState = function (id) {
    // Where id is the starting state
    for (var to = 0; to < this.states.length; to++) {
        if (this.transitions[id][to] !== null) {
            this.transitions[id][to].destroy();
        }
    }
    
    // Where id is the final state
    for (var from = 0; from < this.states.length; from++) {
        if (this.transitions[from][id] !== null) {
            this.transitions[from][id].destroy();
        }
    }
};


/* To remove a state
 */
View.prototype.removeState = function () {
  
    this.clearDrag();
    
    // We remove a state only if it has been selected
    if (this.selectedState !== null) {
        
        // We get its id to remove it from model
        var id = Number(this.selectedState.getId());
        
        // We remove it from the view
        this.selectedState.destroy();
        this.selectedState = null;
        this.removeTransitionsAttachedToState(Number(id));
        this.states[id] = null;
        this.layer.batchDraw();
        
        return id;
    }
    return null;
};


/* To add a transition
 */
View.prototype.addTransition = function () {
    
    var fromId = Number(this.from.getId());
    var toId = Number(this.to.getId());
    
    model.addTransitions(
        fromId,
        [toId, toId],
        [0, 1]
    );
    
    // A transition is represented by an arrow
    var arrow = new Konva.Arrow({
        
        id: this.from.getId() + "-" + this.to.getId(),
        points: this.getConnectorPoints(this.from, this.to),
        
        pointerLength: 10,
        pointerWidth: 10,
        
        fill: "#007bff",
        stroke: "#007bff",
        
        strokeWidth: 2,
        
        tension: 0.5
        
    });
    this.transitions[fromId][toId] = arrow;
    
    // We need to attach a mouse up event to interact with
    arrow.on("mouseup", function (e) {
        view.selectTransition(e.target);
    });
    
    this.createTransition = false;
    this.from = null;
    this.to = null;
    
    // To end, we have to display this arrow
    this.layer.add(arrow);
    this.layer.batchDraw();
    
    this.clearDrag();
};

/* To remove a transition
 */
View.prototype.removeTransition = function () {
  
    this.clearDrag();
  
    // We remove a transition only if it has been selected
    if (this.selectedTransition !== null) {
        
        // We get its id to remove it from model
        var ids = this.selectedTransition.getId().match(/[0-9]+/g);
        var fromId = Number(ids[0]);
        var toId = Number(ids[1]);
        
        // We remove it from the view
        this.selectedTransition.destroy();
        this.selectedTransition = null;
        this.layer.batchDraw();
        this.transitions[fromId][toId] = null;
        
        return [fromId, toId];
    }
    return null;
};


/* To mark a state as selected state
 */
View.prototype.selectState = function (state) {
    $("#remove-state").show();
    $("#remove-transition").hide();
    this.selectedState = state;
    this.selectedTransition = null;
};


/* To mark a transition as selected transition
 */
View.prototype.selectTransition = function (transition) {
    $("#remove-state").hide();
    $("#remove-transition").show();
    this.selectedState = null;
    this.selectedTransition = transition;
};


/* 
 */
View.prototype.getConnectorPoints = function (from, to) {
  
  // 
  var dx = to.x() - from.x();
  var dy = to.y() - from.y();

  //
  var angle = Math.atan2(-dy, dx);
  var radius = 30;
  
  //
  return [
    from.x() - radius * Math.cos(angle + Math.PI),
    from.y() + radius * Math.sin(angle + Math.PI),    
    to.x() - radius * Math.cos(angle),
    to.y() + radius * Math.sin(angle)
  ];
  
};

