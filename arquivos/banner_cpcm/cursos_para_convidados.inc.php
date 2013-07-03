<?php

require '../../conexoes.inc.php';


class cursos_convidados
{
	
	private $db;
	public function __construct(){
		
		$this->db = Database::instance('centralsigma02');
	}
	
	public function recursos_agora(){
		$sql1 = 'select
					rec.id as id_recurso,
					rec.id_curso,
					rec.id_tipo,
					rec.turma_acontecendo_agora,
					rec.titulo,
					rec.texto_descricao,
					rec.link,
					cur.nome,
					tur.horarios
				from cw_cursos_recursos as rec
				join cw_cursos as cur on rec.id_curso = cur.id
				join cw_cursos_turmas as tur on tur.id = rec.turma_acontecendo_agora
				where rec.turma_acontecendo_agora is not null
				order by tur.data_inicio';
		
		$qry1 = $this->db->query($sql1);
		$ret1 = $qry1->fetchAll();
		
		$retorno = array();
		foreach ($ret1 as $res1){
			$retorno[] = $res1;
		}
		
		return $retorno;
	}
	
	public function recursos() {
		
		$sql2 = "select * from 
				(select t.id, t.data_inicio, t.periodo, t.id_curso, 
				r.id as id_recurso,
				   r.id_tipo,
				   r.titulo,
				   r.texto_descricao,
				   r.link,
				   c.nome,
				   t.horarios
				   from cw_cursos_turmas as t
				   left join cw_cursos_recursos as r on t.id_curso = r.id_curso and r.id_tipo = 1
				   left join cw_cursos as c on t.id_curso = c.id
				where t.data_inicio > current_date order by t.id_curso, t.data_inicio,t.id

				) as abc

				group by abc.id_curso order by abc.data_inicio";
		
		/*
		$sql2 = "select
				   rec.id as id_recurso,
				   rec.id_curso,
				   rec.id_tipo,
				   rec.titulo,
				   rec.texto_descricao,
				   rec.link,
				   cur.nome,
				   tur.periodo,
				   tur.horarios
				from 
				   cw_cursos_recursos as rec
				join cw_cursos as cur on 
				   rec.id_curso = cur.id

				join cw_cursos_turmas as tur on 
				   tur.id_curso = cur.id
				   and tur.status = 0
				   and tur.data_inicio = 
					  (select min(data_inicio) 
					  from cw_cursos_turmas tur2 
					  where tur2.id_curso = cur.id
					  and tur2.data_inicio > current_date)

				where 
				   rec.id_tipo=1
				   group by rec.id_curso
				   order by tur.data_inicio";
		*/
		
		$qry2 = $this->db->query($sql2);
		$ret2 = $qry2->fetchAll();
		
		$retorno2 = array();
		foreach ($ret2 as $res2){
			$retorno2[] = $res2;
		}
		
		return $retorno2;
	}
}