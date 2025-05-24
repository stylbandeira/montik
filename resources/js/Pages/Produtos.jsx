import GuestLayout from '@/Layouts/GuestLayout.jsx';
import { Head, router, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import axios from 'axios';

export default function Produtos() {
    const { produtos } = usePage().props;

    const [nomeProduto, setNomeProduto] = useState('');
    const [descricaoProduto, setDescricaoProduto] = useState('');
    const [precoProduto, setPrecoProduto] = useState(0);
    const [quantidadeProduto, setQuantidadeProduto] = useState(0);
    const [modoEdicao, setModoEdicao] = useState(false);
    const [produtoEditando, setProdutoEditando] = useState(null);

    const [variacoes, setVariacoes] = useState([]);
    const [variacoesSelecionadas, setVariacoesSelecionadas] = useState([
        { variacao_id: '', opcao_id: '', opcoes: [] }
    ]);

    const handleVariacaoChange = (index, value) => {
        const novaLista = [...variacoesSelecionadas];
        novaLista[index].variacao_id = value;
        novaLista[index].opcao_id = '';
        const variacao = variacoes.find(v => v.id === parseInt(value));
        novaLista[index].opcoes = variacao ? variacao.opcoes : [];
        setVariacoesSelecionadas(novaLista);
    };

    const handleOpcaoChange = (index, value) => {
        const novaLista = [...variacoesSelecionadas];
        novaLista[index].opcao_id = value;
        setVariacoesSelecionadas(novaLista);
    };

    const adicionarVariacao = () => {
        setVariacoesSelecionadas([
            ...variacoesSelecionadas,
            { variacao_id: '', opcao_id: '', opcoes: [] }
        ]);
    };

    const limparFormulario = () => {
        setNomeProduto('');
        setDescricaoProduto('');
        setPrecoProduto(0);
        setQuantidadeProduto(0);
        setVariacoesSelecionadas([{ variacao_id: '', opcao_id: '', opcoes: [] }]);
    };


    const handleEditarProduto = (produto) => {
        setNomeProduto(produto.nome);
        setDescricaoProduto(produto.descricao);
        setPrecoProduto(produto.preco);
        setQuantidadeProduto(produto.estoque_sum_quantidade ?? 0);
        setProdutoEditando(produto);
        setModoEdicao(true);
    };


    const handleSubmit = (e) => {
        e.preventDefault();
        const data = {
            nomeProduto,
            descricaoProduto,
            precoProduto,
            variacoesSelecionadas,
            quantidadeProduto
        };

        if (modoEdicao && produtoEditando) {
            axios.put(`/api/produtos/${produtoEditando.id}`, data)
                .then(response => {
                    alert(response.data.message);
                    setModoEdicao(false);
                    setProdutoEditando(null);
                    limparFormulario();
                })
                .catch(error => {
                    console.log(error);
                    alert('Erro ao editar produto');
                });
        } else {
            axios.post('/api/estoques', data)
                .then(response => {

                    alert(response.data.message);
                    limparFormulario();
                })
                .catch(error => {
                    console.log(error);
                    alert('Erro ao cadastrar produto');
                });
        }
    }

    const variacoesJaSelecionadas = variacoesSelecionadas.map(v => parseInt(v.variacao_id));

    useEffect(() => {
        axios.get('api/variacoes?with_options=true')
            .then(response => setVariacoes(response.data.variacoes))
            .catch(error => console.error('Erro ao buscar variações', error));
    }, []);

    return (
        <GuestLayout>
            <Head title="Montink" />
            {console.log(produtos[0]['variacoes_produto'])}


            <div className="row">
                <div className="col-8 bg-light p-4">
                    <form className='p-4 border rounded bg-light' onSubmit={handleSubmit}>
                        <h2>{produtoEditando ? 'Editar Produto' : 'Adicionar Produto'}</h2>

                        <div className="mb-3 flex justify-between align-items-center">
                            <label className='mr-3'>Nome do Produto</label>
                            <input
                                className='flex-grow-1'
                                type="text"
                                value={nomeProduto}
                                name='nomeProduto'
                                onChange={(e) => setNomeProduto(e.target.value)}
                            />
                        </div>
                        <div className="mb-3 flex justify-between align-items-center">
                            <label className='mr-3'>Descrição do Produto</label>
                            <input
                                className='flex-grow-1'
                                type="text"
                                value={descricaoProduto}
                                name='descricaoProduto'
                                onChange={(e) => setDescricaoProduto(e.target.value)}
                            />
                        </div>
                        <div className="mb-3 flex justify-between align-items-center">
                            <label className='mr-3'>Preço do Produto</label>
                            <input
                                className='flex-grow-1'
                                type="text"
                                value={precoProduto}
                                name='precoProduto'
                                onChange={(e) => setPrecoProduto(e.target.value)}
                            />
                        </div>

                        <hr />
                        <h4>Variações</h4>

                        {variacoesSelecionadas.map((item, index) => (
                            <div key={index} className="row align-items-end mb-3">
                                <div className="col-md-5">
                                    <label className="form-label">Variação</label>
                                    <select
                                        className="form-select"
                                        value={item.variacao_id}
                                        onChange={e => handleVariacaoChange(index, e.target.value)}
                                        disabled={!(produtoEditando == null)}
                                    >
                                        <option value="">Selecione uma variação</option>
                                        {variacoes
                                            .filter(v => {
                                                return (
                                                    !variacoesJaSelecionadas.includes(v.id) ||
                                                    v.id === parseInt(item.variacao_id)
                                                );
                                            })
                                            .map(v => (
                                                <option key={v.id} value={v.id}>
                                                    {v.nome_variacao}
                                                </option>
                                            ))}
                                    </select>
                                </div>

                                <div className="col-md-5">
                                    <label className="form-label">Opção</label>
                                    <select
                                        className="form-select"
                                        value={item.opcao_id}
                                        onChange={e => handleOpcaoChange(index, e.target.value)}
                                        disabled={!item.opcoes.length}
                                    >
                                        <option value="">Selecione uma opção</option>
                                        {item.opcoes.map(op => (
                                            <option key={op.id} value={op.id}>
                                                {op.valor}
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div className="col-md-2">
                                    {index === variacoesSelecionadas.length - 1 && (
                                        <button
                                            type="button"
                                            className="btn btn-success"
                                            onClick={adicionarVariacao}
                                            disabled={
                                                variacoesSelecionadas.length >= variacoes.length
                                            }
                                        >
                                            +
                                        </button>
                                    )}
                                </div>
                            </div>
                        ))}

                        <hr />
                        <div className="row align-items-end p-4">
                            <h4 className='col-md-6'>Quantidade: </h4>
                            <input
                                className='col-md-6'
                                type="number"
                                placeholder='Digite um número'
                                value={quantidadeProduto}
                                onChange={(e) => setQuantidadeProduto(e.target.value)}
                            />
                        </div>

                        <button type="submit" className="btn btn-primary w-full">Adicionar</button>
                    </form>
                </div>

                <div className="col-4 bg-secondary text-white border-start p-4">
                    <h1 className='text-center'>Estoque</h1>
                    <ul className='list-group'>
                        {produtos.map(produto => (
                            <li key={produto.id} className="list-group-item d-flex justify-content-between align-items-center">
                                <div className="d-flex align-items-center gap-2">
                                    <span className="badge bg-primary rounded-pill">{produto.estoque_sum_quantidade ?? 0}</span>
                                    <span>{produto.nome}</span>
                                </div>

                                <div className="btn-group">
                                    <button
                                        className="btn btn-sm btn-warning"
                                        onClick={() => handleEditarProduto(produto)}
                                    >Editar</button>
                                    <button className="btn btn-sm btn-danger">Excluir</button>
                                </div>
                            </li>
                        ))}
                    </ul>
                </div>

            </div>
        </GuestLayout>
    );
}
