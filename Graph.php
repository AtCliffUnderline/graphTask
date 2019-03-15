<?php
class Graph
{
    protected $graph;
    protected $visited = array();

    public function __construct($graph) {
        $this->graph = $graph;
    }

    // найдем минимальное число прыжков (связей) между 2 узлами

    public function search($origin, $destination) {
        // пометим все узлы как непосещенные
        foreach ($this->graph as $vertex => $adj) {
            $this->visited[$vertex] = false;
        }

        // пустая очередь
        $q = new SplQueue();

        // добавим начальную вершину в очередь и пометим ее как посещенную
        $q->enqueue($origin);
        $this->visited[$origin] = true;

        // это требуется для записи обратного пути от каждого узла
        $path = array();
        $path[$origin] = new SplDoublyLinkedList();
        $path[$origin]->setIteratorMode(
            SplDoublyLinkedList::IT_MODE_FIFO|SplDoublyLinkedList::IT_MODE_KEEP
        );

        $path[$origin]->push($origin);

        // пока очередь не пуста и путь не найден
        while (!$q->isEmpty() && $q->bottom() != $destination) {
            $t = $q->dequeue();

            if (!empty($this->graph[$t])) {
                // для каждого соседнего узла
                foreach ($this->graph[$t] as $vertex) {
                    if (!$this->visited[$vertex]) {
                        // если все еще не посещен, то добавим в очередь и отметим
                        $q->enqueue($vertex);
                        $this->visited[$vertex] = true;
                        // добавим узел к текущему пути
                        $path[$vertex] = clone $path[$t];
                        $path[$vertex]->push($vertex);
                    }
                }
            }
        }

        if (isset($path[$destination])) {
            echo "из '$origin' в '$destination' за ",
                count($path[$destination]) - 1,
            " прыжков:\n";
            $sep = '';
            foreach ($path[$destination] as $vertex) {
                echo $sep, $vertex;
                $sep = ' -> ';
            }
            echo "\n";
        }
        else {
            echo "Нет пути из $origin в $destination";
        }
    }
}