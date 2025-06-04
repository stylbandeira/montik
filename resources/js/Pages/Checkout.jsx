import Carrinho from '@/Components/Carrinho';
import Cupom from '@/Components/Cupom';
import Frete from '@/Components/Frete';
import GuestLayout from '@/Layouts/GuestLayout';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Checkout() {
    const [cep, setCep] = useState('');
    const [nome, setNome] = useState('');
    const [email, setEmail] = useState('');
    const [rua, setRua] = useState('');
    const [numero, setNumero] = useState('');
    const [complemento, setComplemento] = useState('');
    const [bairro, setBairro] = useState('');
    const [cidade, setCidade] = useState('');
    const [estado, setEstado] = useState('');
    const [frete, setFrete] = useState(0);
    const [totalParcial, setTotalParcial] = useState(0);
    const [descontoCupom, setDescontoCupom] = useState(0);
    const [valorTotal, setValorTotal] = useState(0);
    const [cupomAplicado, setCupomAplicado] = useState(null);

    useEffect(() => {
        requestAnimationFrame(() => {
            calculaFrete();
        });

        carrinho.frete = frete;

        localStorage.setItem('carrinho', JSON.stringify(carrinho));
    }, []);

    const calculaFrete = () => {
        const totalParcial = carrinho.reduce((soma, produto) => soma + produto.total_parcial, 0);
        let novoFrete = 0;

        if (totalParcial >= 52 && totalParcial <= 166.59) {
            novoFrete = 15;
        } else if (totalParcial < 52) {
            novoFrete = 20;
        }

        setFrete(novoFrete);
    }


    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    const pesquisaCEP = async (e) => {
        const valor = e.target.value.replace(/\D/g, 1);
        setCep(valor);
        console.log(valor, valor.length);

        if (cep.length === 8) {
            const response = await axios.get(`https://viacep.com.br/ws/${cep}/json/`);
            console.log(response.data);

            setRua(response.data.logradouro)
            setBairro(response.data.bairro)
            setCidade(response.data.localidade)
            setEstado(response.data.estado)
        }
    }

    const finalizarCompra = async (res) => {
        const uuid = localStorage.getItem('uuid');
        console.log(carrinho);

        try {
            await axios.post('/pedidos', {
                carrinho,
                uuid,
                rua,
                numero,
                complemento,
                bairro,
                cidade,
                estado,
                cep,
                email,
                nome,
                frete: frete.toFixed(2),
                cupom: cupomAplicado,
                subtotal: totalParcial.toFixed(2),
                descontos: descontoCupom.toFixed(2),
                total: valorTotal.toFixed(2)
            })

            if (res.status === 400) {
                const data = await res.json();
                alert(data.message);
            }

            if (res.status === 200) {
                const data = await res.json();
                alert(data.message);
            }


        } catch (error) {
            console.error('Erro ao finalizar compra', error);
            alert('Ocorreu um erro ao finalizar sua compra. Tente novamente');
        }
    };

    return <>
        <div className="row">
            <div className="col-md-6">
                <form className="mb-4 p-4 border rounded shadow-sm bg-light">
                    { }
                    <div className="row g-3">
                        <h5 className="mb-4">Dados</h5>
                        <div className="col-md-6">
                            <label htmlFor="email" className="form-label">Email</label>
                            <input
                                className="form-control"
                                name="email"
                                type="email"
                                id="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="nome" className="form-label">Nome</label>
                            <input
                                className="form-control"
                                name="nome"
                                type="nome"
                                id="nome"
                                value={nome}
                                onChange={(e) => setNome(e.target.value)}
                            />
                        </div>
                    </div>

                    <hr />
                    <h5 className="mb-4">Endereço de Entrega</h5>

                    <div className="row g-3">

                        <div className="col-md-8">
                            <label htmlFor="rua" className="form-label">Rua</label>
                            <input
                                className="form-control"
                                name="rua"
                                type="text"
                                id="rua"
                                value={rua}
                                onChange={(e) => setRua(e.target.value)}
                            />
                        </div>

                        <div className="col-md-4">
                            <label htmlFor="numero" className="form-label">Número</label>
                            <input
                                className="form-control"
                                name="numero"
                                type="text"
                                id="numero"
                                value={numero}
                                onChange={(e) => setNumero(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="complemento" className="form-label">Complemento</label>
                            <input
                                className="form-control"
                                name="complemento"
                                type="text"
                                id="complemento"
                                value={complemento}
                                onChange={(e) => setComplemento(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="bairro" className="form-label">Bairro</label>
                            <input
                                className="form-control"
                                name="bairro"
                                type="text"
                                id="bairro"
                                value={bairro}
                                onChange={(e) => setBairro(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="cidade" className="form-label">Cidade</label>
                            <input
                                className="form-control"
                                name="cidade"
                                type="text"
                                id="cidade"
                                value={cidade}
                                onChange={(e) => setCidade(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="estado" className="form-label">Estado</label>
                            <input
                                className="form-control"
                                name="estado"
                                type="text"
                                id="estado"
                                value={estado}
                                onChange={(e) => setEstado(e.target.value)}
                            />
                        </div>

                        <div className="col-md-6">
                            <label htmlFor="estado" className="form-label">CEP</label>
                            <input
                                className="form-control"
                                name="estado"
                                maxLength="9"
                                type="text"
                                id="estado"
                                onChange={pesquisaCEP}
                                value={cep}
                            />
                        </div>
                    </div>

                    <button type="submit" onClick={finalizarCompra} className="btn btn-success w-100 mt-3">
                        Finalizar Compra
                    </button>
                </form>
            </div>
            <div className="col-md-6 card">
                <Carrinho
                    cart={carrinho}
                    cupomAplicado={cupomAplicado}
                    frete={frete}
                    totalParcial={totalParcial}
                    descontoCupom={descontoCupom}
                    valorTotal={valorTotal}
                    setTotalParcial={setTotalParcial}
                    setDescontoCupom={setDescontoCupom}
                    setValorTotal={setValorTotal}
                ></Carrinho>
                <Cupom carrinho={carrinho} cupomAplicado={cupomAplicado} setCupomAplicado={setCupomAplicado}></Cupom>
            </div>

        </div >
    </>;
}

Checkout.layout = (page) => <GuestLayout children={page} />;
