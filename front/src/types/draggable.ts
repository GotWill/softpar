export interface DraggableEvent<T> {
  added?: {
    element: T;
    newIndex: number;
  };
  removed?: {
    element: T;
    oldIndex: number;
  };
  moved?: {
    element: T;
    newIndex: number;
    oldIndex: number;
  };
}
