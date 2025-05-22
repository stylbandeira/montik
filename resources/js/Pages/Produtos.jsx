import ApplicationLogo from '@/Components/ApplicationLogo';
import Header from '@/Components/Header';
import { Link, Head, usePage } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout.jsx';
import { useEffect, useState } from 'react';

export default function Produtos() {
    const { produtos } = usePage().props;
    const [produto, setProduto] = useState({
        nome: '',
        descricao: '',
        preco: '',
    });

    const [variacoes, setVariacoes] = useState([]);
    const [variacaoSelecionada, setVariacaoSelecionada] = useState('');
    const [opcoes, setOpcoes] = useState([]);

    const [estoque, setEstoque] = useState({
        quantidade: 0
    });

    const handleVariacaoChange = (e) => {
        const id = parseInt(e.target.value);
        console.log(e)
        setVariacaoSelecionada(e.target.value);

        const variacao = variacoes.variacoes.find(v => v.id === id);
        setOpcoes(variacao.opcoes);
    }

    useEffect(() => {
        axios.get('api/variacoes?with_options=true')
            .then(response => setVariacoes(response.data))
            .catch(error => console.error('Erro ao buscar variações', error))
    }, []);

    return (
        <GuestLayout>
            <Head title="Montink" />

            <div className="row">
                <div className="col-8 bg-light p-4">

                    {/* FORM */}
                    <form action="" className='p-4 border rounded bg-light'>
                        <h2>Adicionar Produto</h2>

                        <div className="mb-3">
                            <label htmlFor="">Nome do Produto</label>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="">Descrição do Produto</label>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="">Preço do Produto</label>
                        </div>
                        <hr></hr>

                        <h4>Variações</h4>
                        <div className="row">
                            <div className="mb-3 col-md-5">
                                <label className="form-label">Variação</label>
                                <select
                                    className="form-select"
                                    value={variacaoSelecionada}
                                    onChange={handleVariacaoChange}
                                >
                                    <option value="">Selecione uma variação</option>
                                    {/* {console.log(variacoes)} */}
                                    {(variacoes.variacoes || []).map((v) => (
                                        <option key={v.id} value={v.id}>{v.nome_variacao}</option>
                                    ))}
                                </select>
                            </div>
                            {console.log(opcoes)}

                            {/* Dropdown de Opções */}
                            {opcoes.length > 0 && (
                                <div className='col-md-5'>
                                    <label className="form-label">Opções</label>
                                    <select className="form-select">
                                        <option value="">Selecione uma opção</option>
                                        {opcoes.map((op) => (
                                            <option key={op.id} value={op.id}>{op.valor}</option>
                                        ))}
                                    </select>
                                </div>
                            )}
                        </div>
                        <hr />

                        <h4>Quantidade: xxxx</h4>
                        <button>Adicionar</button>
                    </form>
                </div>


                <div className="col-4 bg-secondary text-white border-start p-4">
                    <h1 className='text-center'>Lista de Produtos</h1>

                    <ul className='bg-white text-black'>
                        {produtos.map(produto => (
                            <li key={produto.id}>{produto.nome}</li>
                        ))}
                    </ul>
                </div>
            </div>
        </GuestLayout >
    );
}
